<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Notifications\EmployeeResignationNotify;
use App\Notifications\ResignationApplicationNotification;
use App\Notifications\ResignationApprovedNotification;
use App\Models\Resignation;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ResignationController extends Controller {

	
		public function index()
	{
		$logged_user = auth()->user();
		$companies = Company::select('id', 'company_name')->get();
		$employee = \App\Models\Employee::where('id', $logged_user->id)->first();

		if ($logged_user->can('view-resignation'))
		{
			if (request()->ajax())
			{
				// Get role and user ID
				$roleId = $logged_user->role_users_id;
				$userId = $logged_user->id;

				// Base query
				$resignationQuery = Resignation::with('company', 'employee', 'department');

				// Role-based filtering
				if (in_array($roleId, [1, 6])) {
					// Admin or Manager: see all resignations
					$resignations = $resignationQuery->get();
				} elseif ($roleId == 4) {
					// Team Lead: see own resignation + team members
					$resignations = $resignationQuery->whereHas('employee', function ($q) use ($userId) {
						$q->where('id', $userId)->orWhere('team_lead', $userId);
					})->get();
				} elseif ($roleId == 2) {
					// Normal Employee: only own resignation
					$resignations = $resignationQuery->where('employee_id', $userId)->get();
				} else {
					// Default to empty
					$resignations = collect();
				}

				return datatables()->of($resignations)
					->setRowId(function ($resignation) {
						return $resignation->id;
					})
					->addColumn('company', function ($row) {
						return $row->company->company_name ?? '';
					})
					->addColumn('department', function ($row) {
						return $row->department->department_name ?? '';
					})
					->addColumn('employee', function ($row) {
						return $row->employee->full_name ?? 'N/A';
					})
					->addColumn('status', function ($row) {
						$status = $row->getApprovalStatusText();
						$badgeClass = '';
						
						if ($row->isApproved()) {
							$badgeClass = 'badge-success';
						} elseif ($row->isRejected()) {
							$badgeClass = 'badge-danger';
						} else {
							$badgeClass = 'badge-warning';
						}
						
						return '<span class="badge ' . $badgeClass . '">' . $status . '</span>';
					})
					->addColumn('action', function ($data) {
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';

						// Add approval buttons for HR and Admin
						$logged_user = auth()->user();
						
						// HR approval buttons
						if ($logged_user->role_users_id == 6 && !$data->hr_approved && $data->status == 'pending') {
							$button .= '<button type="button" name="hr_approve" id="' . $data->id . '" class="hr_approve btn btn-info btn-sm" title="HR Approve"><i class="fa fa-check"></i> HR Approve</button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="hr_reject" id="' . $data->id . '" class="hr_reject btn btn-warning btn-sm" title="HR Reject"><i class="fa fa-times"></i> HR Reject</button>';
							$button .= '&nbsp;&nbsp;';
						}
						
						// Admin approval buttons
						if ($logged_user->role_users_id == 1 && !$data->admin_approved && $data->status == 'pending') {
							$button .= '<button type="button" name="admin_approve" id="' . $data->id . '" class="admin_approve btn btn-success btn-sm" title="Admin Approve"><i class="fa fa-check"></i> Admin Approve</button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="admin_reject" id="' . $data->id . '" class="admin_reject btn btn-danger btn-sm" title="Admin Reject"><i class="fa fa-times"></i> Admin Reject</button>';
							$button .= '&nbsp;&nbsp;';
						}

						$resignation_date = new DateTime($data->resignation_date);
						$current_date = new DateTime();
						if ($resignation_date > $current_date->setTime(0, 0, 0, 0)) {
							if (auth()->user()->can('edit-resignation')) {
								$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
								$button .= '&nbsp;&nbsp;';
							}
							if (auth()->user()->can('delete-resignation')) {
								$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
							}
						} elseif ($resignation_date < $current_date->setTime(0, 0, 0, 0)) {
							$button .= '<a href="'.route('resignations.restore', $data->id).'" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Restore Data"><i class="fa fa-undo"></i></a>';
							$button .= '&nbsp;&nbsp;';
						}
						return $button;
					})
					->rawColumns(['action', 'status'])
					->make(true);
			}

			return view('core_hr.resignation.index', compact('companies', 'employee'));
		}

		return abort('403', __('You are not authorized'));
	}


    protected function employeeLeaveDateSet($employee_id, $date){
        $employee = Employee::find($employee_id);
        $employee->exit_date = $date;
        $employee->update();
    }

	public function store(Request $request)
	{

		$logged_user = auth()->user();
		if ($logged_user->can('store-resignation'))
		{
			$validator = Validator::make($request->only('description', 'company_id', 'department_id', 'employee_id', 'resignation_date', 'notice_date'
			),
				[
					'company_id' => 'required',
					'department_id' => 'required',
					'employee_id' => 'required',
					'resignation_date' => 'required',
					'notice_date' => 'required'
				]
			);

			if ($validator->fails()){
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];
			$data['employee_id'] = $request->employee_id;
			$data['company_id'] = $request->company_id;
			$data['department_id'] = $request->department_id;
			$data['description'] = $request->description;
			$data['resignation_date'] = $request->resignation_date;
			$data['notice_date'] = $request->notice_date;
			Resignation::create($data);
            $this->employeeLeaveDateSet($request->employee_id, $request->resignation_date);
			$notifiable = User::findOrFail($data['employee_id']);
            $this->setEmployeeExitDate($request->employee_id, $request->resignation_date);

			// Send email notifications to HR and Admin users
			$this->sendResignationNotifications($request);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function show($id)
	{
		if (request()->ajax())
		{
			$data = Resignation::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$first_name = $data->employee->first_name ?? '';
			$last_name = $data->employee->full_name ?? '';
			$employee_name = $first_name . ' ' . $last_name;
			$department = $data->department->department_name ?? '';

			return response()->json(['data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name, 'department' => $department]);
		}
	}

	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = Resignation::findOrFail($id);

			$departments = Department::select('id', 'department_name')
				->where('company_id', $data->company_id)->get();

			$employees = Employee::select('id', 'first_name', 'last_name')->where('department_id', $data->department_id)->where('is_active',1)->get();


			return response()->json(['data' => $data, 'employees' => $employees, 'departments' => $departments]);
		}
	}

	public function update(Request $request)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('edit-resignation'))
		{
			$id = $request->hidden_id;
			$validator = Validator::make($request->only('description', 'company_id', 'department_id', 'employee_id', 'resignation_date', 'notice_date'
			),
				[
					'company_id' => 'required',
					'department_id' => 'required',
					'employee_id' => 'required',
					'resignation_date' => 'required',
					'notice_date' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];
			$data['description'] = $request->description;
			$data['resignation_date'] = $request->resignation_date;
			$data['notice_date'] = $request->notice_date;
			$data['employee_id'] = $request->employee_id;
			$data['company_id'] = $request->company_id;
			$data['department_id'] = $request->department_id;

			Resignation::find($id)->update($data);
            $this->employeeLeaveDateSet($request->employee_id, $request->resignation_date);
            $this->setEmployeeExitDate($request->employee_id, $request->resignation_date);

			return response()->json(['success' => __('Data is successfully updated')]);
		}
		return response()->json(['success' => __('You are not authorized')]);

	}


	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-resignation'))
		{
            $resignation = Resignation::find($id);
            $resignation->delete();

            $this->setEmployeeExitDate($resignation->employee_id , null);

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function delete_by_selection(Request $request)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-resignation'))
		{

			$resignation_id = $request['resignationIdArray'];
			$resignation = Resignation::whereIntegerInRaw('id', $resignation_id);
			if ($resignation->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Resignation')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected resignation can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

    public function restore(Resignation $resignation)
    {
        Employee::where('id', $resignation->employee_id)
            ->update(['exit_date' => null]);
        $resignation->delete();

        return redirect()->back()->with([
            'message' => 'Successfully Restored',
            'type' => 'success',
        ]);
    }

    protected function setEmployeeExitDate($employeeId, $resignationDate)
    {
        $exitDate = null;
        if(!is_null($resignationDate)) {
            $exitDate = Carbon::parse($resignationDate)->toDateString();
        }
        Employee::where('id', $employeeId)
                ->update(['exit_date' => $exitDate]);
    }

    /**
     * Send resignation application notifications to HR and Admin users
     */
    protected function sendResignationNotifications($request)
    {
        try {
            // Get employee details
            $employee = Employee::with('company', 'department')->find($request->employee_id);
            if (!$employee) {
                return;
            }

            // Get HR users (role_users_id = 6)
            $hrUsers = User::where('role_users_id', 6)->get();
            
            // Get Admin users (role_users_id = 1)
            $adminUsers = User::where('role_users_id', 1)->get();

            // Combine HR and Admin users
            $usersToNotify = $hrUsers->merge($adminUsers)->unique('id');

            // Prepare notification data
            $employeeName = $employee->first_name . ' ' . $employee->last_name;
            $companyName = $employee->company->company_name ?? 'N/A';
            $departmentName = $employee->department->department_name ?? 'N/A';

            // Send notifications to all HR and Admin users
            foreach ($usersToNotify as $user) {
                $user->notify(new ResignationApplicationNotification(
                    $employeeName,
                    $request->resignation_date,
                    $request->notice_date,
                    $request->description,
                    $companyName,
                    $departmentName
                ));
            }

            // Also send email notifications using Notification facade for additional email delivery
            foreach ($usersToNotify as $user) {
                if ($user->email) {
                    Notification::route('mail', $user->email)
                        ->notify(new ResignationApplicationNotification(
                            $employeeName,
                            $request->resignation_date,
                            $request->notice_date,
                            $request->description,
                            $companyName,
                            $departmentName
                        ));
                }
            }

        } catch (\Exception $e) {
            // Log the error but don't break the resignation process
            \Log::error('Failed to send resignation notifications: ' . $e->getMessage());
        }
    }

    /**
     * HR approval for resignation
     */
    public function hrApprove(Request $request, $id)
    {
        $logged_user = auth()->user();
        
        // Debug logging
        \Log::info('HR approval attempt', [
            'user_id' => $logged_user->id,
            'user_role' => $logged_user->role_users_id,
            'resignation_id' => $id,
            'request_data' => $request->all()
        ]);
        
        // Check if user is HR
        if ($logged_user->role_users_id != 6) {
            \Log::warning('Non-HR user attempted approval', [
                'user_id' => $logged_user->id,
                'user_role' => $logged_user->role_users_id
            ]);
            return response()->json(['error' => 'Only HR can approve resignations'], 403);
        }

        $resignation = Resignation::findOrFail($id);
        
        if ($resignation->hr_approved) {
            return response()->json(['error' => 'Resignation already approved by HR'], 400);
        }

        $resignation->update([
            'hr_approved' => true,
            'hr_approved_by' => $logged_user->id,
            'hr_approved_at' => now(),
            'hr_approval_notes' => $request->notes ?? null
        ]);

        \Log::info('Resignation updated by HR', [
            'resignation_id' => $resignation->id,
            'hr_approved' => $resignation->hr_approved,
            'hr_approved_by' => $resignation->hr_approved_by
        ]);

        // Check if both HR and Admin have approved
        $this->checkAndUpdateResignationStatus($resignation);

        return response()->json(['success' => 'Resignation approved by HR successfully']);
    }

    /**
     * Admin approval for resignation
     */
    public function adminApprove(Request $request, $id)
    {
        $logged_user = auth()->user();
        
        // Debug logging
        \Log::info('Admin approval attempt', [
            'user_id' => $logged_user->id,
            'user_role' => $logged_user->role_users_id,
            'resignation_id' => $id,
            'request_data' => $request->all()
        ]);
        
        // Check if user is Admin
        if ($logged_user->role_users_id != 1) {
            \Log::warning('Non-admin user attempted approval', [
                'user_id' => $logged_user->id,
                'user_role' => $logged_user->role_users_id
            ]);
            return response()->json(['error' => 'Only Admin can approve resignations'], 403);
        }

        $resignation = Resignation::findOrFail($id);
        
        if ($resignation->admin_approved) {
            return response()->json(['error' => 'Resignation already approved by Admin'], 400);
        }

        $resignation->update([
            'admin_approved' => true,
            'admin_approved_by' => $logged_user->id,
            'admin_approved_at' => now(),
            'admin_approval_notes' => $request->notes ?? null
        ]);

        \Log::info('Resignation updated by admin', [
            'resignation_id' => $resignation->id,
            'admin_approved' => $resignation->admin_approved,
            'admin_approved_by' => $resignation->admin_approved_by
        ]);

        // Check if both HR and Admin have approved
        $this->checkAndUpdateResignationStatus($resignation);

        return response()->json(['success' => 'Resignation approved by Admin successfully']);
    }

    /**
     * HR rejection for resignation
     */
    public function hrReject(Request $request, $id)
    {
        $logged_user = auth()->user();
        
        // Check if user is HR
        if ($logged_user->role_users_id != 6) {
            return response()->json(['error' => 'Only HR can reject resignations'], 403);
        }

        $resignation = Resignation::findOrFail($id);
        
        $resignation->update([
            'status' => 'rejected',
            'hr_approved' => false,
            'hr_approved_by' => $logged_user->id,
            'hr_approved_at' => now(),
            'hr_approval_notes' => $request->notes ?? null
        ]);

        return response()->json(['success' => 'Resignation rejected by HR successfully']);
    }

    /**
     * Admin rejection for resignation
     */
    public function adminReject(Request $request, $id)
    {
        $logged_user = auth()->user();
        
        // Check if user is Admin
        if ($logged_user->role_users_id != 1) {
            return response()->json(['error' => 'Only Admin can reject resignations'], 403);
        }

        $resignation = Resignation::findOrFail($id);
        
        $resignation->update([
            'status' => 'rejected',
            'admin_approved' => false,
            'admin_approved_by' => $logged_user->id,
            'admin_approved_at' => now(),
            'admin_approval_notes' => $request->notes ?? null
        ]);

        return response()->json(['success' => 'Resignation rejected by Admin successfully']);
    }

    /**
     * Check if both HR and Admin have approved and update status accordingly
     */
    protected function checkAndUpdateResignationStatus($resignation)
    {
        if ($resignation->hr_approved && $resignation->admin_approved) {
            $resignation->update(['status' => 'approved']);
            
            // Send notification to employee that resignation is approved
            $this->sendResignationApprovedNotification($resignation);
        }
    }

    /**
     * Send notification when resignation is fully approved
     */
    protected function sendResignationApprovedNotification($resignation)
    {
        try {
            $employee = Employee::find($resignation->employee_id);
            if ($employee) {
                $employeeUser = User::find($employee->id);
                if ($employeeUser) {
                    $employeeUser->notify(new ResignationApprovedNotification(
                        $resignation->resignation_date,
                        $resignation->notice_date
                    ));
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send resignation approved notification: ' . $e->getMessage());
        }
    }
}
