<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExeWorkingReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $loggedUser = auth()->user();

        $query = Employee::query()
            ->select([
                'employees.id as employee_id',
                'employees.first_name',
                'employees.last_name',
                'employees.staff_id',
                DB::raw('CONCAT(employees.first_name, " ", employees.last_name) as name'),
                // Last clock_up within optional date range
                DB::raw('(SELECT MAX(clock_up) FROM attendances 
                          WHERE employee_id = employees.id'
                          .($startDate ? ' AND DATE(clock_up) >= "'.addslashes($startDate).'"' : '')
                          .($endDate ? ' AND DATE(clock_up) <= "'.addslashes($endDate).'"' : '')
                          .') as last_clock_up')
            ]);

        // Only show all if admin or HR, otherwise filter to current user
        if (!in_array($loggedUser->role_users_id, [1, 6])) {
            $query->where('staff_id', $loggedUser->staff_id);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('staff_id', 'like', "%{$search}%");
            });
        }

        $employees = $query->get()->map(function($employee) use ($status) {
            $clockUp = $employee->last_clock_up ? strtotime($employee->last_clock_up) : null;
            $now = time();
            $empStatus = 'Inactive';
            if ($clockUp && abs($now - $clockUp) <= 300) { // 300 seconds = 5 minutes
                $empStatus = 'Active';
            }
            // If filtering by status, skip employees that don't match
            if ($status && $empStatus !== $status) {
                return null;
            }
            return [
                'employee_id' => $employee->employee_id,
                'name' => $employee->name,
                'staff_id' => $employee->staff_id,
                'clock_up' => $employee->last_clock_up ? date('Y-m-d H:i:s', $clockUp) : 'N/A',
                'status' => $empStatus
            ];
        })->filter();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('streaming._employee_grid', [
                    'employees' => $employees,
                    'hide_stream_button' => true
                ])->render()
            ]);
        }

        return view('streaming.index', [
            'employees' => $employees,
            'search' => $search,
            'status' => $status
        ]);
    }
} 