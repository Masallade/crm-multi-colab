<?php

namespace App\Http\Controllers;

use App\Models\OffDeskHours;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OffDeskHoursController extends Controller
{
    public function index(){
        $employees = \App\Models\Employee::select('id', 'first_name', 'last_name')->where('is_active', 1)->get();
        $offDeskRecords = Attendance::where('off_desk_hours', true)
            ->with('employee')
            ->orderBy('attendance_date', 'desc')
            ->get();
        return view('timesheet.attendance.off_desk_hours', compact('employees', 'offDeskRecords'));
    }
    
    public function store(\Illuminate\Http\Request $request)
    {
        try {
            $requestId = uniqid('off_desk_');
            Log::info("[OffDeskHours][$requestId] New off-desk hours submission started", [
                'request_data' => $request->except(['_token']),
                'user_agent' => $request->userAgent(),
                'ip_address' => $request->ip()
            ]);

            // Validate request data
            Log::info("[OffDeskHours][$requestId] Starting request validation");
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|exists:employees,id',
                'date' => 'required|date|before_or_equal:today|after_or_equal:' . Carbon::now()->subDays(7)->format('Y-m-d'),
                'time_in' => 'required',
                'time_out' => 'required',
                'message' => 'required|string|max:500',
            ]);

            if ($validator->fails()) {
                Log::warning("[OffDeskHours][$requestId] Validation failed", [
                    'validation_errors' => $validator->errors()->toArray(),
                    'submitted_data' => $request->except(['_token'])
                ]);
                return back()->withErrors($validator)->withInput();
            }

            $employee_id = $request->employee_id;
            $date = $request->date;
            $time_in = $request->time_in;
            $time_out = $request->time_out;
            $message = $request->message;

            Log::info("[OffDeskHours][$requestId] Validation passed successfully", [
                'employee_id' => $employee_id,
                'date' => $date,
                'time_in' => $time_in,
                'time_out' => $time_out,
                'message_length' => strlen($message)
            ]);

            // Get employee and shift information
            $employee = Employee::with('officeShift')->find($employee_id);
            if (!$employee) {
                Log::error("[OffDeskHours][$requestId] Employee not found", ['employee_id' => $employee_id]);
                return back()->withInput()->withErrors(['employee_id' => 'Employee not found']);
            }

            // Get shift times for the selected date
            $dayOfWeek = strtolower(Carbon::parse($date)->format('l'));
            $shiftIn = null;
            $shiftOut = null;
            
            if ($employee->officeShift) {
                $shiftIn = $employee->officeShift->{$dayOfWeek . '_in'};
                $shiftOut = $employee->officeShift->{$dayOfWeek . '_out'};
            }

            Log::info("[OffDeskHours][$requestId] Shift information", [
                'day_of_week' => $dayOfWeek,
                'shift_in' => $shiftIn,
                'shift_out' => $shiftOut,
                'has_office_shift' => $employee->officeShift ? true : false
            ]);

            // Convert to timestamps for database storage
            try {
                Log::info("[OffDeskHours][$requestId] Converting date and time to timestamps");
                $clock_in_ts = strtotime("$date $time_in");
                $clock_out_ts = strtotime("$date $time_out");

                if ($clock_in_ts === false || $clock_out_ts === false) {
                    Log::error("[OffDeskHours][$requestId] Failed to convert time strings to timestamps", [
                        'date' => $date,
                        'time_in' => $time_in,
                        'time_out' => $time_out
                    ]);
                    throw new \Exception('Invalid date/time format');
                }

                // Check if time_out is after time_in
                if ($clock_out_ts <= $clock_in_ts) {
                    Log::warning("[OffDeskHours][$requestId] Time out is not after time in", [
                        'clock_in_ts' => $clock_in_ts,
                        'clock_out_ts' => $clock_out_ts,
                        'time_difference' => $clock_out_ts - $clock_in_ts
                    ]);
                    return back()->withInput()->withErrors(['time_out' => 'Time out must be after time in']);
                }

                // Shift validation
                if ($shiftIn && $shiftOut) {
                    $shiftInTs = strtotime("$date $shiftIn");
                    $shiftOutTs = strtotime("$date $shiftOut");
                    
                    // Handle night shifts (shift ends next day)
                    if ($shiftOutTs < $shiftInTs) {
                        $shiftOutTs = strtotime("$date $shiftOut +1 day");
                    }
                    
                    // Validate clock in (time out) should be greater than shift start
                    if ($clock_in_ts < $shiftInTs) {
                        Log::warning("[OffDeskHours][$requestId] Clock in is before shift start", [
                            'clock_in_ts' => $clock_in_ts,
                            'shift_in_ts' => $shiftInTs,
                            'clock_in_formatted' => date('Y-m-d H:i:s', $clock_in_ts),
                            'shift_in_formatted' => date('Y-m-d H:i:s', $shiftInTs)
                        ]);
                        return back()->withInput()->withErrors(['time_in' => 'Time out must be after shift start time (' . $shiftIn . ')']);
                    }
                    
                    // Validate clock out (time in) should be smaller than shift end
                    if ($clock_out_ts > $shiftOutTs) {
                        Log::warning("[OffDeskHours][$requestId] Clock out is after shift end", [
                            'clock_out_ts' => $clock_out_ts,
                            'shift_out_ts' => $shiftOutTs,
                            'clock_out_formatted' => date('Y-m-d H:i:s', $clock_out_ts),
                            'shift_out_formatted' => date('Y-m-d H:i:s', $shiftOutTs)
                        ]);
                        return back()->withInput()->withErrors(['time_out' => 'Time in must be before shift end time (' . $shiftOut . ')']);
                    }
                }

                Log::info("[OffDeskHours][$requestId] Time conversion completed successfully", [
                    'clock_in_ts' => $clock_in_ts,
                    'clock_out_ts' => $clock_out_ts,
                    'clock_in_formatted' => date('Y-m-d h:i:s A', $clock_in_ts),
                    'clock_out_formatted' => date('Y-m-d h:i:s A', $clock_out_ts),
                    'duration_minutes' => round(($clock_out_ts - $clock_in_ts) / 60)
                ]);
            } catch (\Exception $e) {
                Log::error("[OffDeskHours][$requestId] Time conversion failed", [
                    'error_message' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                    'date' => $date,
                    'time_in' => $time_in,
                    'time_out' => $time_out
                ]);
                return back()->withInput()->withErrors(['time_in' => 'Invalid time format']);
            }

            // Calculate attendance parameters
            Log::info("[OffDeskHours][$requestId] Calculating attendance parameters");
            
            // Calculate total work time
            $totalWorkSeconds = $clock_out_ts - $clock_in_ts;
            $totalWork = gmdate('H:i:s', $totalWorkSeconds);
            
            // Calculate late time (if clock in is after shift start)
            $timeLate = '00:00:00';
            if ($shiftIn) {
                $shiftInTs = strtotime("$date $shiftIn");
                if ($clock_in_ts > $shiftInTs) {
                    $lateSeconds = $clock_in_ts - $shiftInTs;
                    $timeLate = gmdate('H:i:s', $lateSeconds);
                }
            }
            
            // Calculate early leaving (if clock out is before shift end)
            $earlyLeaving = '00:00:00';
            if ($shiftOut) {
                $shiftOutTs = strtotime("$date $shiftOut");
                // Handle night shifts
                if ($shiftOutTs < strtotime("$date $shiftIn")) {
                    $shiftOutTs = strtotime("$date $shiftOut +1 day");
                }
                if ($clock_out_ts < $shiftOutTs) {
                    $earlySeconds = $shiftOutTs - $clock_out_ts;
                    $earlyLeaving = gmdate('H:i:s', $earlySeconds);
                }
            }
            
            // Calculate overtime (if clock out is after shift end)
            $overtime = '00:00:00';
            if ($shiftOut) {
                $shiftOutTs = strtotime("$date $shiftOut");
                // Handle night shifts
                if ($shiftOutTs < strtotime("$date $shiftIn")) {
                    $shiftOutTs = strtotime("$date $shiftOut +1 day");
                }
                if ($clock_out_ts > $shiftOutTs) {
                    $overtimeSeconds = $clock_out_ts - $shiftOutTs;
                    $overtime = gmdate('H:i:s', $overtimeSeconds);
                }
            }
            
            // Calculate early arrival (if clock in is before shift start)
            $earlyArrival = '00:00:00';
            if ($shiftIn) {
                $shiftInTs = strtotime("$date $shiftIn");
                if ($clock_in_ts < $shiftInTs) {
                    $earlySeconds = $shiftInTs - $clock_in_ts;
                    $earlyArrival = gmdate('H:i:s', $earlySeconds);
                }
            }

            Log::info("[OffDeskHours][$requestId] Calculated parameters", [
                'total_work' => $totalWork,
                'time_late' => $timeLate,
                'early_leaving' => $earlyLeaving,
                'overtime' => $overtime,
                'early_arrival' => $earlyArrival
            ]);

            // Create new attendance record
            Log::info("[OffDeskHours][$requestId] Creating new attendance record");
            $attendance = new \App\Models\Attendance();
            $attendance->employee_id = $employee_id;
            $attendance->attendance_date = $date;
            $attendance->clock_in = date('h:i:s A', $clock_in_ts);
            $attendance->clock_in_ip = null;
            $attendance->clock_out = date('h:i:s A', $clock_out_ts);
            $attendance->clock_out_ip = null;
            $attendance->clock_in_out = 0;
            $attendance->time_late = $timeLate;
            $attendance->early_leaving = $earlyLeaving;
            $attendance->overtime = $overtime;
            $attendance->total_work = $totalWork;
            $attendance->total_rest = '00:00:00';
            $attendance->attendance_status = 'present';
            $attendance->clock_up = date('Y-m-d H:i:s', $clock_out_ts);
            $attendance->early_arrival = $earlyArrival;
            $attendance->off_desk_hours = true;
            $attendance->message = $message;
            
            Log::info("[OffDeskHours][$requestId] Attempting to save attendance record", [
                'attendance_data' => $attendance->toArray()
            ]);
            
            $attendance->save();

            Log::info("[OffDeskHours][$requestId] Attendance record saved successfully", [
                'attendance_id' => $attendance->id,
                'employee_id' => $attendance->employee_id,
                'attendance_date' => $attendance->attendance_date
            ]);

            return redirect()->route('off_desk_hours.index')
                ->with('success', 'Off-desk hours adjustment has been completed successfully.');

        } catch (\Exception $e) {
            Log::error("[OffDeskHours][$requestId] Unexpected error in off-desk hours submission", [
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['_token'])
            ]);
            
            return redirect()->route('off_desk_hours.index')
                ->with('error', 'Failed to submit off-desk hours. Please try again.');
        }
    }

    public function getEmployeeShift(Request $request)
    {
        try {
            $employeeId = $request->employee_id;
            $date = $request->date;
            
            if (!$employeeId || !$date) {
                return response()->json(['success' => false, 'message' => 'Employee ID and date are required']);
            }
            
            $employee = Employee::with('officeShift')->find($employeeId);
            if (!$employee || !$employee->officeShift) {
                return response()->json(['success' => false, 'message' => 'Employee or shift not found']);
            }
            
            $dayOfWeek = strtolower(Carbon::parse($date)->format('l'));
            $dayName = Carbon::parse($date)->format('l');
            
            $shiftIn = $employee->officeShift->{$dayOfWeek . '_in'};
            $shiftOut = $employee->officeShift->{$dayOfWeek . '_out'};
            
            return response()->json([
                'success' => true,
                'shift' => $employee->officeShift,
                'day_of_week' => $dayOfWeek,
                'day_name' => $dayName,
                'shift_in' => $shiftIn,
                'shift_out' => $shiftOut
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching employee shift', [
                'error' => $e->getMessage(),
                'employee_id' => $request->employee_id,
                'date' => $request->date
            ]);
            
            return response()->json(['success' => false, 'message' => 'Error fetching shift information']);
        }
    }

    public function destroy($id)
    {
        try {
            $record = Attendance::where('id', $id)
                ->where('off_desk_hours', true)
                ->firstOrFail();
            
            $record->delete();
            
            return redirect()->route('off_desk_hours.index')
                ->with('success', 'Off-desk hours record deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting off-desk hours record', [
                'error' => $e->getMessage(),
                'record_id' => $id
            ]);
            
            return redirect()->route('off_desk_hours.index')
                ->with('error', 'Failed to delete off-desk hours record.');
        }
    }
} 