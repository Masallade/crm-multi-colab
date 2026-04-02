<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\EmployeeLeaveTypeDetail;
use App\Models\Leave;
use Illuminate\Console\Command;

class DiagnoseLeaveData extends Command
{
    protected $signature = 'leave:diagnose {employee_id?}';
    protected $description = 'Diagnose leave data inconsistencies';

    private const MINUTES_PER_DAY = 1440;

    public function handle()
    {
        $employeeId = $this->argument('employee_id');
        
        if ($employeeId) {
            $employees = Employee::where('id', $employeeId)->with('employeeLeaveTypeDetail', 'employeeLeave')->get();
        } else {
            $employees = Employee::with('employeeLeaveTypeDetail', 'employeeLeave')->get();
        }

        $this->info("Diagnosing leave data for " . $employees->count() . " employee(s)...\n");

        foreach ($employees as $employee) {
            $this->info("Employee: {$employee->first_name} {$employee->last_name} (ID: {$employee->id})");
            
            if (!$employee->employeeLeaveTypeDetail) {
                $this->warn("  No leave type details found");
                continue;
            }

            $leaveDetails = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);
            
            if (!is_array($leaveDetails)) {
                $this->error("  Invalid leave details data");
                continue;
            }

            foreach ($leaveDetails as $leave) {
                $leaveTypeName = $leave['leave_type'] ?? 'Unknown';
                $leaveTypeId = $leave['leave_type_id'] ?? 0;
                $allocated = $leave['allocated_day'] ?? 0;
                $remaining = $leave['remaining_allocated_day'] ?? 0;

                // Calculate actual taken leave from database
                $takenMinutes = $employee->employeeLeave
                    ->where('leave_type_id', $leaveTypeId)
                    ->where('status', 'approved')
                    ->sum('total_days');
                
                $takenDays = $takenMinutes / self::MINUTES_PER_DAY;
                $expectedRemaining = $allocated - $takenDays;

                $this->line("  {$leaveTypeName}:");
                $this->line("    Allocated: {$allocated} days");
                $this->line("    Stored Remaining: {$remaining} days");
                $this->line("    Taken (from DB): " . round($takenDays, 2) . " days");
                $this->line("    Expected Remaining: " . round($expectedRemaining, 2) . " days");
                
                if (abs($remaining - $expectedRemaining) > 0.1) {
                    $this->error("    ⚠️  MISMATCH DETECTED!");
                }
                $this->line("");
            }
        }

        return 0;
    }
}
