<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\GeneralSetting;
use App\Models\leave;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

//Notification
use App\Notifications\EmployeeLeaveNotification; //Mail
use App\Notifications\LeaveNotification; //Database
use App\Notifications\LeaveNotificationToAdmin; //Database
use App\Models\User;
use App\Models\EmployeeLeaveTypeDetail;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{

    public function index(Request $request)
    {
        // dd('ok');
        $check_status = $request->status;
        $companies = Company::select('id', 'company_name')->get();
        $departments = Department::select('id', 'department_name')->get();
        $leave_types = LeaveType::select('id', 'leave_type', 'allocated_day')->get();

        
        $logged_user = auth()->user();

        $EmployeeLeaveTypeDetail = EmployeeLeaveTypeDetail::where('employee_id', $logged_user->id)->first();	
		// Decode the serialized leave type details
		$leaveTypeDetails = unserialize($EmployeeLeaveTypeDetail->leave_type_detail);


$query = Leave::with('employee.officeShift', 'department', 'LeaveType')->orderBy('id', 'DESC');

if ($logged_user->role_users_id == 4) {
    $query->whereHas('employee', function ($query) use ($logged_user) {
        $query->where('team_lead', $logged_user->id)
              ->orWhere('id', $logged_user->id); // Include the logged-in user's own leave
    });
} elseif ($logged_user->role_users_id == 2) {
    $query->whereHas('employee', function ($query) use ($logged_user) {
        $query->where('id', $logged_user->id);
    });
} elseif ($logged_user->role_users_id == 9) {
    // Restrict to the logged-in user's department and team (including own)
    $loggedEmployee = Employee::find($logged_user->id);
    if ($loggedEmployee) {
        $query->where(function ($q) use ($loggedEmployee, $logged_user) {
            $q->where('department_id', $loggedEmployee->department_id)
              ->orWhereHas('employee', function ($sub) use ($logged_user) {
                  $sub->where('team_lead', $logged_user->id)
                      ->orWhere('id', $logged_user->id);
              });
        });
    }
}

if ($check_status) {
    // If status is "pending", check if 'is_tl_action' is 0
    if ($check_status == "pending") {
        $query->where('status', 'pending')
              ->where('is_tl_action', 0); // Ensure 'is_tl_action' is 0
    } 
    // If status is 1 (Approved by Teamlead), show TL-approved items that are not fully approved yet
    elseif ($check_status == 1) {
        $query->where('is_tl_action', 1)
              ->where('status', '!=', 'approved');
    } 
    // Otherwise, filter normally by status
    else {
        $query->where('status', $check_status);
    }
}

$leave = $query->get();
$leaveCountPending = Leave::where('status', 'pending')->count();
        $minutes_per_day = 24 * 60; // 1440 = calendar day (so 4d 17h 41m = 6821 min)

        if ($logged_user->can('view-leave')) {
            if (request()->ajax()) {
                return datatables()->of($leave)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('leave_type', function ($row) {
                        return $row->LeaveType->leave_type ?? '';
                    })
                    ->addColumn('department', function ($row) {
                        return $row->department->department_name ?? '';
                    })
                    ->addColumn('employee', function ($row) {
                        return $row->employee->full_name ?? '';
                    })
                    ->addColumn('created_at', function ($row) {
                        try {
                            // Convert UTC to Pakistan time (Asia/Karachi)
                            return \Carbon\Carbon::parse($row->created_at)
                                ->setTimezone('Asia/Karachi')
                                ->format('d-m-Y - H:i');
                        } catch (\Exception $e) {
                            // Fallback to original value if parsing fails
                            return $row->created_at;
                        }
                    })
                    ->addColumn('action', function ($data) use ($logged_user) {
                        $button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
                        // HR can always edit/delete
                        if ($logged_user->role_users_id == 6) {
                            $button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                            $button .= '&nbsp;&nbsp;';
                            $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                        } else {
                            if (auth()->user()->can('edit-leave')) {
                                $button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                                $button .= '&nbsp;&nbsp;';
                            }
                            if (auth()->user()->can('delete-leave')) {
                                $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                            }
                        }
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('timesheet.leave.index', compact('companies', 'departments', 'leave_types', 'leaveTypeDetails', 'minutes_per_day'));
        }

        return abort('403', __('You are not authorized'));
    }

    /**
     * Get shift duration (whole hours and remaining minutes) for the given date
     * based on the employee's office shift. Used by the Total Days Hours/Minutes
     * dropdowns when selecting a partial day of leave.
     */
    public function getShiftHoursForDate(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'date'        => ['required', 'string'],
        ]);

        $employee = Employee::with('officeShift')->find($validated['employee_id']);

        if (!$employee || !$employee->officeShift) {
            // Fallback if no shift is assigned.
            return response()->json(['hours' => 0, 'minutes' => 0]);
        }

        $dateStr = $validated['date'];
        $date = null;

        // Try common formats used in the app: d-m-Y (UI) and Y-m-d (backend)
        foreach (['d-m-Y', 'Y-m-d'] as $format) {
            try {
                $date = Carbon::createFromFormat($format, $dateStr);
                if ($date !== false) {
                    break;
                }
            } catch (\Throwable $e) {
                $date = null;
            }
        }

        if (!$date) {
            return response()->json(['hours' => 0, 'minutes' => 0]);
        }

        $dayOfWeek = strtolower($date->format('l')); // monday, tuesday, ...
        $inKey  = $dayOfWeek . '_in';
        $outKey = $dayOfWeek . '_out';

        $shiftIn  = $employee->officeShift->$inKey  ?? null;
        $shiftOut = $employee->officeShift->$outKey ?? null;

        if (!$shiftIn || !$shiftOut) {
            return response()->json(['hours' => 0, 'minutes' => 0]);
        }

        $shiftStart = strtotime($shiftIn);
        $shiftEnd   = strtotime($shiftOut);

        if ($shiftStart === false || $shiftEnd === false || $shiftEnd <= $shiftStart) {
            return response()->json(['hours' => 0, 'minutes' => 0]);
        }

        $totalMinutes = (int) max(0, ($shiftEnd - $shiftStart) / 60);

        $hours = intdiv($totalMinutes, 60);
        $minutesRemainder = $totalMinutes % 60;

        // Keep hours within 0–23 for the dropdown
        if ($hours > 23) {
            $hours = 23;
            // Recompute remainder within this capped range
            $minutesRemainder = $totalMinutes - ($hours * 60);
            if ($minutesRemainder < 0) {
                $minutesRemainder = 0;
            }
        }

        return response()->json([
            'hours'   => $hours,
            'minutes' => $minutesRemainder,
        ]);
    }

    public function store(Request $request)
    {
        
        // dd(notifyUser(240, 'Leave Request', 'A new leave has been applied.'));
        if (auth()->user()->can('store-leave') || auth()->user()) {
            $validator = Validator::make(
                $request->only('leave_type', 'company_id', 'department_id', 'employee_id', 'start_date', 'end_date', 'status'),
                [
                    'company_id' => 'required',
                    'department_id' => 'required',
                    'employee_id' => 'required',
                    'leave_type' => 'required',
                    'status' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required|after_or_equal:start_date'
                ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $currentDate = new DateTime();
            $requestStartDate = new DateTime($request->start_date);
            $requestEndDate = new DateTime($request->end_date);

            // Removed check for end date being less than current date
            // Add check: end date must be same or after start date
            if ($requestEndDate < $requestStartDate) {
                throw new Exception('The end date must be the same as or after the start date');
            }

            // Calculate leave deduction based on employee shift
            // Get days, hours, minutes from request (sent separately from frontend)
            $fullDays = $request->filled('total_days_d') ? (int)$request->total_days_d : 0;
            $partialHours = $request->filled('total_days_h') ? (int)$request->total_days_h : 0;
            $partialMinutes = $request->filled('total_days_m') ? (int)$request->total_days_m : 0;
            
            // Calculate actual deduction using shift-based logic
            $requestedMinutes = $this->calculateLeaveDeduction(
                $request->employee_id,
                $request->end_date,
                $fullDays,
                $partialHours,
                $partialMinutes
            );
            
            // Fallback: if frontend sent diff_date_hidden and we got 0 from calculation, use it
            if ($requestedMinutes == 0 && $request->filled('diff_date_hidden') && is_numeric($request->diff_date_hidden)) {
                $requestedMinutes = (int) $request->diff_date_hidden;
            }
            
            // Validate requested duration does not exceed remaining allocated days
            if ($requestedMinutes > 0) {
                $minutesPerDay = $this->getMinutesPerDay();
                $employeeLeaveDetail = EmployeeLeaveTypeDetail::where('employee_id', $request->employee_id)->first();
                if ($employeeLeaveDetail && $employeeLeaveDetail->leave_type_detail) {
                    $leaveTypeUnserialize = @unserialize($employeeLeaveDetail->leave_type_detail);
                    if (is_array($leaveTypeUnserialize)) {
                        foreach ($leaveTypeUnserialize as $item) {
                            if (!is_array($item)) continue;
                            if ((int)($item['leave_type_id'] ?? 0) === (int)$request->leave_type) {
                                $remaining = isset($item['remaining_allocated_day']) && is_numeric($item['remaining_allocated_day'])
                                    ? (float) $item['remaining_allocated_day'] : 0;
                                $remainingMinutes = (int) round($remaining * $minutesPerDay);
                                if ($requestedMinutes > $remainingMinutes) {
                                    $requestedDays = $minutesPerDay > 0 ? ($requestedMinutes / $minutesPerDay) : 0;
                                    return response()->json([
                                        'remaining_leave' => 'Insufficient leave balance. Available: ' . number_format($remaining, 2) . ' days, Requested: ' . number_format($requestedDays, 2) . ' days.'
                                    ]);
                                }
                                break;
                            }
                        }
                    }
                }
            }

            try {
                $leave = LeaveType::findOrFail($request->leave_type);
                $data = [];
                $data['employee_id'] = $request->employee_id;
                $data['company_id'] = $request->company_id;
                $data['department_id'] = $request->department_id;
                $data['leave_type_id'] = $request->leave_type;
                $data['leave_reason'] = $request->leave_reason;
                $data['remarks'] = $request->remarks;
                $data['status'] = $request->status;
                $data['is_notify'] = $request->is_notify;
                $data['start_date'] = $request->start_date;
                $data['end_date'] = $request->end_date;
                // total_days column stores duration in minutes (calculated based on employee shift)
                $data['total_days'] = $request->total_days;
                $data['is_half'] = ($requestedMinutes === 720) ? 1 : ($request->is_half ?? 0); // 720 min = 0.5 day

                if ($request->status == 'approved') {
                    try {
                        // When creating a new leave with approved status, deduct days from employee_leave_type_details
                        $this->employeeLeaveTypeDataManage(null, $request, $request->employee_id, $request->leave_type, false);
                    } catch (Exception $e) {
                        return response()->json(['error' => $e->getMessage()]);
                    }
                }

                $data['created_at'] = Carbon::now('Asia/Karachi');
                $data['updated_at'] = Carbon::now('Asia/Karachi');
                $leave = leave::create($data);

                // In-app notifications (database channel)
                    $employee = Employee::findOrFail($data['employee_id']);
                $teamLead = Employee::find($employee->team_lead);
                $hrs = User::where('role_users_id', 6)->get();
                $admins = User::where('role_users_id', 1)->get();
                $employeeUser = User::find($employee->id); // Assuming employee id == user id

                $teamLeadName = $teamLead ? ($teamLead->first_name . ' ' . $teamLead->last_name) : 'N/A';
                $hrName = $hrs->count() > 0 ? $hrs->pluck('first_name')->implode(', ') : 'N/A';

                $leaveTypeName = $leave->LeaveType->leave_type ?? 'Leave';
                $durationText = $leave->total_days_display;
                $notificationMessage = $employee->first_name . ' ' . $employee->last_name . " has applied for $leaveTypeName ($durationText).";

                // Notify the employee (self)
                if ($employeeUser) {
                    $employeeUser->notify(new \App\Notifications\LeaveNotification(
                        "You have applied for the leave ($durationText) and your teamlead $teamLeadName and hr $hrName will be responsible (approve or reject) on it."
                    ));
                }

                // Collect all users to notify (team lead, HR, admin)
                $usersToNotify = collect();
                if ($teamLead && $teamLead->id != $employee->id) {
                    $teamLeadUser = User::find($teamLead->id); // Assuming employee id == user id
                    if ($teamLeadUser) {
                        $usersToNotify->push($teamLeadUser);
                    }
                }
                $usersToNotify = $usersToNotify->merge($hrs)->merge($admins);
                $usersToNotify = $usersToNotify->unique('id');

                foreach ($usersToNotify as $user) {
                    $user->notify(new \App\Notifications\LeaveNotificationToAdmin($notificationMessage));
                    }

                    // push notification
                    // notifyUser(240, 'Leave Request', 'A new leave has been applied.');
                    // Mail
                    $fullActionBy = "";
                    $department = Department::with('DepartmentHead:id,email')->where('id', $request->department_id)->first();
                    if(isset($department->DepartmentHead->email)) {
                        Notification::route('mail', $department->DepartmentHead->email)
                        ->notify(new EmployeeLeaveNotification(
                            $leave->employee->full_name,
                            $leave->total_days_display,
                            $leave->start_date,
                            $leave->end_date,
                            $leave->leave_reason,
                        $fullActionBy,
                        $leaveTypeName,
                        $leave->status,
                        $teamLeadName,
                        $hrName
                    ));
                    }

                    // Send email to all HRs
                    foreach ($hrs as $hr) {
                        if (!empty($hr->email)) {
                            Notification::route('mail', $hr->email)
                                ->notify(new EmployeeLeaveNotification(
                                    $leave->employee->full_name,
                                    $leave->total_days_display,
                                    $leave->start_date,
                                    $leave->end_date,
                                    $leave->leave_reason,
                                    $fullActionBy,
                                    $leaveTypeName,
                                    $leave->status,
                                    $teamLeadName,
                                    $hrName
                                ));
                        }
                    }

                // Push Notification Logic (non-blocking: do not show errors to user if table missing or send fails)
                try {
                    Log::info('Push notification: Starting to send push notifications to users', ['usersToNotify' => $usersToNotify->pluck('id')->toArray()]);
                    $firebaseService = app(\App\Services\FirebaseService::class);
                    foreach ($usersToNotify as $user) {
                        $tokens = \App\Models\PushNotificationToken::where('user_id', $user->id)->pluck('token');
                        Log::info('Push notification: Found tokens for user', ['user_id' => $user->id, 'tokens' => $tokens]);
                        foreach ($tokens as $token) {
                            try {
                                Log::info('Push notification: Sending notification', ['user_id' => $user->id, 'token' => $token]);
                                $firebaseService->sendNotification($token, 'Leave Request', $notificationMessage);
                                Log::info('Push notification: Notification sent successfully', ['user_id' => $user->id, 'token' => $token]);
                            } catch (\Exception $e) {
                                Log::error('Push notification: Failed to send notification', ['user_id' => $user->id, 'token' => $token, 'error' => $e->getMessage()]);
                            }
                        }
                    }
                    Log::info('Push notification: Finished sending push notifications');
                } catch (\Throwable $e) {
                    Log::warning('Push notification: Skipped (e.g. table missing or service unavailable)', ['error' => $e->getMessage()]);
                }

            }
            catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }

            return response()->json(['success' => __('Data Added successfully.')]);
        }
        return response()->json(['success' => __('You are not authorized')]);
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = leave::with('employee.officeShift', 'company', 'department', 'LeaveType')->findOrFail($id);
            $company_name = $data->company->company_name ?? '';
            $employee_name = $data->employee->full_name;
            $department = $data->department->department_name ?? '';
            $leave_type_name = $data->LeaveType->leave_type ?? '';

            $start_date_name = $data->start_date;
            $end_date_name = $data->end_date;


            // Format created_at to Pakistan time
            try {
                $data->created_at_formatted = \Carbon\Carbon::parse($data->created_at)
                    ->setTimezone('Asia/Karachi')
                    ->format('d-m-Y - H:i');
            } catch (\Exception $e) {
                $data->created_at_formatted = $data->created_at;
            }

            return response()->json([
                'data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name, 'department' => $department, 'leave_type_name' => $leave_type_name,
                'start_date_name' => $start_date_name, 'end_date_name' => $end_date_name
            ]);
        }
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $loggedUser = auth()->user(); // Get the logged-in user
            $roleId = $loggedUser->role_users_id; // Get the logged-in user
            $userId = $loggedUser->id; // Get the logged-in user
           
            $data = leave::with('employee:id,first_name,last_name,office_shift_id', 'employee.officeShift', 'department:id,department_name', 'company:id,company_name')
                ->select('*') // Explicitly select all fields including leave_reason
                ->findOrFail($id);
            
            // Ensure leave_reason is included in the response
            if (!isset($data->leave_reason)) {
                $data->leave_reason = $data->getAttribute('leave_reason') ?? '';
            }

            $leaveStartDate = date('Y-m-d', strtotime($data->start_date));

            $departments = Department::select('id', 'department_name')
                ->where('company_id', $data->company_id)->get();
            
                // Base query for active employees without an exit date
            $query = Employee::select('id', 'first_name', 'last_name')
            ->where('is_active', 1)
            ->whereNull('exit_date');
            // Apply filters based on the role
            switch ($roleId) {
                case 1: // Admin
                case 6: // HR
                case 9: // COO
                    // No additional filters needed, show all employees
                    break;

                case 4: // Manager
                    // Show employees under this manager (team_lead) and also include the manager's own data
                    $query->where(function ($q) use ($userId) {
                        $q->where('team_lead', $userId)
                        ->orWhere('id', $userId); // Also include the manager's own details
                    });
                    break;

                case 2: // Employee
                    // Show only the logged-in employee's data
                    $query->where('id', $userId);
                    break;

                default:
                    // Handle unexpected roles (optional)
                    return response()->json(['error' => 'Unauthorized role'], 403);
            }

                // Fetch the employees based on the applied filters
                $employees = $query->get();

            // $employees = Employee::select('id', 'first_name', 'last_name')->where('department_id', $data->department_id)->where('is_active', 1)->where('exit_date', NULL)->get();

            return response()->json(['data' => $data, 'employees' => $employees, 'departments' => $departments, 'leaveStartDate' => $leaveStartDate]);
        }
    }

    public function update(Request $request)
{
    // dump($request->all());
    // Debug: Show all request data on screen
    // dd($request->all());
    
    $logged_user = auth()->user();

    // Add Leave: the form posts to this same route for both Add and Edit. When hidden_id is not sent, it's Add → use store().
    if (!$request->filled('hidden_id')) {
        return $this->store($request);
    }

    if ($logged_user->can('edit-leave')) {
        $id = $request->hidden_id;

        $validator = Validator::make(
            $request->all(),
            [
                'hidden_id'        => 'required',
                'company_id'       => 'required',
                'department_id'    => 'required',
                'employee_id'      => 'required_without:employee_id_hidden',
                'leave_type'       => 'required_without:leave_type_hidden',
                'status'           => 'required',
                'start_date'       => 'required',
                'end_date'         => 'required|after_or_equal:start_date',
                'diff_date_hidden' => 'nullable|numeric',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $leave = Leave::find($id);
        if (!$leave) {
            return response()->json(['errors' => [__('Leave record not found.')]], 404);
        }

        // Resolve employee_id
        $employee_id = $request->filled('employee_id')
            ? $request->employee_id
            : $request->employee_id_hidden;

        // Resolve leave_type - use request value, hidden value, or existing leave's leave_type_id
        $leave_type = $request->filled('leave_type')
            ? $request->leave_type
            : ($request->leave_type_hidden ?? $leave->leave_type_id);

        // Resolve status
        $isTeamLead = $logged_user->role_users_id == 4;
        $requestedStatus = $request->status;

        $data = [];

        if ($isTeamLead && $requestedStatus === '1') {
            // Team Lead approving → mark TL action, keep status as pending for HR
            $data['status']       = 'pending';
            $data['is_tl_action'] = 1;
        } else {
            // Map '1' → 'approved' for non-TL roles (safety net)
            if ($requestedStatus === '1') {
                $requestedStatus = 'approved';
            }
            $data['status'] = in_array($requestedStatus, ['approved', 'rejected', 'pending'])
                ? $requestedStatus
                : 'pending';
            $data['is_tl_action'] = 0;
        }

        // HR action flag
        $data['is_hr_action'] = $logged_user->role_users_id == 6 ? 1 : 0;

        // Core fields
        $data['leave_reason']  = $request->leave_reason ?? '';
        $data['remarks']       = $request->remarks ?? '';
        $data['is_notify']     = $request->is_notify ? 1 : 0;
        $data['start_date']    = $request->start_date;
        $data['end_date']      = $request->end_date;
        $data['employee_id']   = $employee_id;
        $data['leave_type_id'] = $leave_type;

        if ($request->filled('company_id')) {
            $data['company_id'] = $request->company_id;
        }

        if ($request->filled('department_id')) {
            $data['department_id'] = $request->department_id;
        }

        // Only update total_days if a valid numeric value was actually sent (minutes)
        if ($request->filled('diff_date_hidden') && is_numeric($request->diff_date_hidden)) {
            $data['total_days'] = (int) $request->diff_date_hidden;
            $data['is_half']    = ((int) $request->diff_date_hidden === 720) ? 1 : 0;
        }

        // Determine whether to restore or deduct remaining leave balance
        $isEmployeeRemainingLeaveRestore = null;
        $oldStatus = $leave->status;
        $newStatus = $data['status'];
        
        if ($oldStatus === 'approved' && in_array($newStatus, ['pending', 'rejected'])) {
            $isEmployeeRemainingLeaveRestore = true;   // restore days back
        } elseif (in_array($oldStatus, ['pending', 'rejected']) && $newStatus === 'approved') {
            $isEmployeeRemainingLeaveRestore = false;  // deduct days
        }

        // Log for debugging
        \Log::info('Leave Update - Status Change', [
            'leave_id' => $leave->id,
            'employee_id' => $employee_id,
            'leave_type_id' => $leave_type,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'isRestore' => $isEmployeeRemainingLeaveRestore,
            'diff_date_hidden' => $request->diff_date_hidden ?? 'not set'
        ]);

        try {
            // Update employee_leave_type_details when leave status changes
            $this->employeeLeaveTypeDataManage($leave, $request, $employee_id, $leave_type, $isEmployeeRemainingLeaveRestore);
            // Update the leave record
            \Log::info('Leave Update - Before Save', ['data_to_save' => $data]);
            $leave->update($data);

            // Notification
            $actionBy  = $logged_user->first_name . ' ' . $logged_user->last_name;
            $roleNames = [1 => 'Admin', 4 => 'Team Lead', 6 => 'HR'];
            $roleName  = $roleNames[$logged_user->role_users_id] ?? 'User';
            $fullActionBy = "$roleName $actionBy";

            if ($data['status'] === 'approved') {
                $text = "Your leave request has been approved by $fullActionBy.";
            } elseif ($data['status'] === 'rejected') {
                $text = "Your leave request has been rejected by $fullActionBy.";
            } else {
                $text = "Your leave request is pending and under review by $fullActionBy.";
            }

            $notifiableUserId = $employee_id ?? $leave->employee_id;
            if ($notifiableUserId) {
                $notifiable = User::findOrFail($notifiableUserId);
                $notifiable->notify(new LeaveNotification($text));
            }

        } catch (\Throwable $e) {
            Log::error('Leave update error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['success' => __('Data is successfully updated')]);
    }

    return response()->json(['success' => __('You are not authorized')]);
}


    /** Minutes per calendar day (24h). Leave balance and deduction use this so 1 day = 1440 min (e.g. 4d 17h 41m = 6821 min). */
    private function getMinutesPerDay(): int
    {
        return 24 * 60; // 1440
    }

    /**
     * Calculate leave deduction in minutes based on employee shift
     * 
     * @param int $employeeId Employee ID
     * @param string $endDate Leave end date (Y-m-d format)
     * @param int $fullDays Number of full days
     * @param int $partialHours Partial day hours
     * @param int $partialMinutes Partial day minutes
     * @return int Total deduction in minutes
     */
    private function calculateLeaveDeduction($employeeId, $endDate, $fullDays, $partialHours, $partialMinutes): int
    {
        $MINUTES_PER_CALENDAR_DAY = 1440; // 24 hours
        
        // Calculate full days deduction (always 24-hour calendar days)
        $fullDaysMinutes = $fullDays * $MINUTES_PER_CALENDAR_DAY;
        
        // If no partial day, return full days only
        if ($partialHours == 0 && $partialMinutes == 0) {
            return $fullDaysMinutes;
        }
        
        // Get employee with office shift
        $employee = Employee::with('officeShift')->find($employeeId);
        
        if (!$employee || !$employee->officeShift) {
            // Fallback: if no shift found, use standard 8-hour shift
            $shiftMinutes = 8 * 60; // 480 minutes
        } else {
            // Get day of week from end date
            $dayOfWeek = strtolower(Carbon::parse($endDate)->format('l')); // monday, tuesday, etc.
            
            $inColumn = $dayOfWeek . '_in';
            $outColumn = $dayOfWeek . '_out';
            
            $shiftIn = $employee->officeShift->$inColumn;
            $shiftOut = $employee->officeShift->$outColumn;
            
            if (!$shiftIn || !$shiftOut) {
                // No shift defined for this day, use 8-hour default
                $shiftMinutes = 8 * 60;
            } else {
                // Calculate shift duration in minutes
                try {
                    $inTime = Carbon::parse($shiftIn);
                    $outTime = Carbon::parse($shiftOut);
                    $shiftMinutes = $outTime->diffInMinutes($inTime);
                } catch (\Exception $e) {
                    // Error parsing times, use default
                    $shiftMinutes = 8 * 60;
                }
            }
        }
        
        // Calculate partial day deduction
        $leaveMinutes = ($partialHours * 60) + $partialMinutes;
        $remainingShiftMinutes = $shiftMinutes - $leaveMinutes;
        $calendarDeduction = $MINUTES_PER_CALENDAR_DAY - $remainingShiftMinutes;
        
        // Total deduction
        return $fullDaysMinutes + $calendarDeduction;
    }

    private function parseDateToDateTime($dateStr)
    {
        if (empty($dateStr)) {
            return null;
        }
        $format = env('Date_Format');
        if ($format) {
            try {
                $d = \Carbon\Carbon::createFromFormat($format, $dateStr);
                if ($d) {
                    return $d->toDateTime();
                }
            } catch (\Exception $e) {
                // fall through
            }
        }
        try {
            return \Carbon\Carbon::parse($dateStr)->toDateTime();
        } catch (\Exception $e) {
            return null;
        }
    }

    private function employeeLeaveTypeDataManage($leave, $request, $employee_id, $leave_type_id, $isRestore)
    {
        
        // Only update remaining days if $isRestore is explicitly set (true/false), not null
        // null means no status change affecting leave balance
        if ($isRestore === null) {
            \Log::info('employeeLeaveTypeDataManage: Skipping update - isRestore is null');
            return;
        }

        // Get employee leave type details
        $employeeLeaveTypeDetail = EmployeeLeaveTypeDetail::where('employee_id', $employee_id)->first();
        
        if (!$employeeLeaveTypeDetail) {
            \Log::warning('employeeLeaveTypeDataManage: No EmployeeLeaveTypeDetail found', ['employee_id' => $employee_id]);
            return;
        }

        $leaveTypeUnserialize = unserialize($employeeLeaveTypeDetail->leave_type_detail);
        
        if (!is_array($leaveTypeUnserialize) || empty($leaveTypeUnserialize)) {
            \Log::warning('employeeLeaveTypeDataManage: Invalid or empty serialized data', ['employee_id' => $employee_id]);
            return;
        }

        $dataLeaveType = [];
        $leaveTypeFound = false;
        
        // total_days and diff_date_hidden are stored/sent in minutes
        $diffDateHidden = $request->diff_date_hidden;
        
        // For leave deduction, we need to use shift-based calculation, not raw form input
        if ($isRestore === false) {
            // When deducting (approving leave), use shift-based calculation
            $fullDays = $request->filled('total_days_d') ? (int)$request->total_days_d : 0;
            $partialHours = $request->filled('total_days_h') ? (int)$request->total_days_h : 0;
            $partialMinutes = $request->filled('total_days_m') ? (int)$request->total_days_m : 0;
            
            // If form fields are not available (editing existing leave), extract from stored total_days
            if ($fullDays === 0 && $partialHours === 0 && $partialMinutes === 0) {
                $totalMinutes = 0;
                if ($diffDateHidden !== '' && $diffDateHidden !== null && is_numeric($diffDateHidden)) {
                    $totalMinutes = (int) $diffDateHidden;
                } else {
                    $totalMinutes = $leave ? (int)($leave->total_days ?? 0) : 0;
                }
                
                $minutesPerDay = $this->getMinutesPerDay();
                if ($totalMinutes > 0 && $minutesPerDay > 0) {
                    $fullDays = intval($totalMinutes / $minutesPerDay);
                    $remainingMinutes = $totalMinutes % $minutesPerDay;
                    $partialHours = intval($remainingMinutes / 60);
                    $partialMinutes = $remainingMinutes % 60;
                }
            }
            
            // Use shift-based calculation for deduction
            $diffMins = $this->calculateLeaveDeduction(
                $employee_id,
                $request->end_date ?? $leave->end_date,
                $fullDays,
                $partialHours,
                $partialMinutes
            );
            
            \Log::info('employeeLeaveTypeDataManage: Using shift-based calculation for deduction', [
                'fullDays' => $fullDays,
                'partialHours' => $partialHours,
                'partialMinutes' => $partialMinutes,
                'calculated_diffMins' => $diffMins,
                'raw_diff_date_hidden' => $diffDateHidden,
                'totalMinutes_input' => $totalMinutes ?? 'not_calculated'
            ]);
        } else {
            // For restoration, use the stored value from the leave record
            if ($diffDateHidden !== '' && $diffDateHidden !== null && is_numeric($diffDateHidden)) {
                $diffMins = (int) $diffDateHidden;
            } else {
                $diffMins = $leave ? (int)($leave->total_days ?? 0) : 0;
            }
        }
        $minutesPerDay = $this->getMinutesPerDay();
        $diffDays = $minutesPerDay > 0 ? ($diffMins / $minutesPerDay) : 0;
        
        \Log::info('employeeLeaveTypeDataManage: Starting update', [
            'employee_id' => $employee_id,
            'leave_type_id' => $leave_type_id,
            'isRestore' => $isRestore,
            'diffMins' => $diffMins,
            'diff_date_hidden_from_request' => $request->diff_date_hidden ?? 'not set',
            'leave_total_days_mins' => $leave ? ($leave->total_days ?? 'not set') : 'leave is null',
            'leave_types_count' => count($leaveTypeUnserialize)
        ]);

        // Find the specific leave type from the serialized data and update remaining_allocated_day
        foreach ($leaveTypeUnserialize as $key => $itemArr) {
            if (!is_array($itemArr)) {
                continue;
            }

            // Use direct comparison with leave_type_id for reliable matching
            $currentLeaveTypeId = isset($itemArr['leave_type_id']) ? (int)$itemArr['leave_type_id'] : null;
            
            if ($currentLeaveTypeId === (int)$leave_type_id) {
                $leaveTypeFound = true;
                
                $currentRemaining = 0;
                if (isset($itemArr['remaining_allocated_day']) && is_numeric($itemArr['remaining_allocated_day'])) {
                    $currentRemaining = (float) $itemArr['remaining_allocated_day'];
                }
                
                $currentRemainingMins = (int) round($currentRemaining * $minutesPerDay);
                
                if ($isRestore === false && $diffMins > 0) {
                    if ($diffMins > $currentRemainingMins) {
                        throw new Exception('Allocated quota for this leave type is less than requested. Available: ' . number_format($currentRemaining, 2) . ' days, Requested: ' . number_format($diffDays, 2) . ' days.');
                    }
                }
                
                // Do all arithmetic in minutes to avoid floating-point errors (e.g. 3d 4h 34m - 3d 4h 31m = 3 minutes)
                if ($isRestore === true) {
                    $newRemainingMins = $currentRemainingMins + $diffMins;
                } else if ($isRestore === false) {
                    $newRemainingMins = max(0, $currentRemainingMins - $diffMins);
                } else {
                    $newRemainingMins = $currentRemainingMins;
                }
                
                $newRemaining = $minutesPerDay > 0 ? ($newRemainingMins / $minutesPerDay) : 0;
                $dataLeaveType[$key]['remaining_allocated_day'] = $newRemaining;
                \Log::info('employeeLeaveTypeDataManage: ' . ($isRestore ? 'Restore' : 'Deduct') . ' (in minutes)', [
                    'leave_type_id' => $leave_type_id,
                    'currentMins' => $currentRemainingMins,
                    'diffMins' => $diffMins,
                    'newMins' => $newRemainingMins,
                    'newDecimal' => $newRemaining
                ]);
            } else {
                // Keep other leave types unchanged - preserve their existing values
                $dataLeaveType[$key]['remaining_allocated_day'] = isset($itemArr['remaining_allocated_day']) 
                    ? (is_numeric($itemArr['remaining_allocated_day']) ? (float)$itemArr['remaining_allocated_day'] : $itemArr['remaining_allocated_day'])
                    : 0;
            }
            
            // Preserve all other fields exactly as they are
            $dataLeaveType[$key]['leave_type_id'] = $itemArr['leave_type_id'] ?? null;
            $dataLeaveType[$key]['leave_type'] = $itemArr['leave_type'] ?? '';
            $dataLeaveType[$key]['allocated_day'] = isset($itemArr['allocated_day']) 
                ? (is_numeric($itemArr['allocated_day']) ? (float)$itemArr['allocated_day'] : $itemArr['allocated_day'])
                : 0;
        }

        // Only update if we found the leave type and have data to save
        if ($leaveTypeFound && !empty($dataLeaveType)) {
            EmployeeLeaveTypeDetail::updateOrCreate(
                ['employee_id' => $employee_id],
                ['leave_type_detail' => serialize($dataLeaveType)]
            );
            \Log::info('employeeLeaveTypeDataManage: Successfully updated EmployeeLeaveTypeDetail', [
                'employee_id' => $employee_id,
                'leave_type_id' => $leave_type_id,
                'updated' => true
            ]);
        } else {
            \Log::warning('employeeLeaveTypeDataManage: Leave type not found or no data to save', [
                'employee_id' => $employee_id,
                'leave_type_id' => $leave_type_id,
                'leaveTypeFound' => $leaveTypeFound,
                'dataLeaveType_empty' => empty($dataLeaveType)
            ]);
        }
    }




    public function destroy($id)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['error' => 'This feature is disabled for demo!']);
        }
        $logged_user = auth()->user();

        if ($logged_user->can('delete-leave')) {
            leave::whereId($id)->delete();

            return response()->json(['success' => __('Data is successfully deleted')]);
        }
        return response()->json(['success' => __('You are not authorized')]);
    }






    public function delete_by_selection(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['error' => 'This feature is disabled for demo!']);
        }
        $logged_user = auth()->user();

        if ($logged_user->can('delete-leave')) {

            $leave_id = $request['leaveIdArray'];
            $leave = leave::whereIntegerInRaw('id', $leave_id);
            if ($leave->delete()) {
                return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Leave')])]);
            } else {
                return response()->json(['error' => 'Error, selected leaves can not be deleted']);
            }
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function calendarableDetails($id)
    {
        if (request()->ajax()) {
            $data = Leave::with(
                'company:id,company_name',
                'LeaveType:id,leave_type',
                'employee:id,first_name,last_name'
            )->findOrFail($id);

            $new = [];

            $new['Company'] = $data->company->company_name;
            $new['Employee'] = $data->employee->full_name;
            $new['Arrangement Type'] = $data->LeaveType->leave_type;
            $new['Start Date'] = $data->start_date;
            $new['End Date'] = $data->end_date;
            $new['Leave Reason'] = $data->leave_reason;
            $new['Remarks'] = $data->remarks;
            $new['Status'] = 'Approved';

            return response()->json(['data' => $new]);
        }
    }
}
