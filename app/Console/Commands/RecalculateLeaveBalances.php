<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\EmployeeLeaveTypeDetail;
use App\Models\LeaveType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecalculateLeaveBalances extends Command
{
    protected $signature = 'leave:recalculate {employee_id?} {--dry-run}';
    protected $description = 'Recalculate leave balances based on approved leaves';

    private const MINUTES_PER_DAY = 1440;

    public function handle()
    {
        $employeeId = $this->argument('employee_id');
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn("DRY RUN MODE - No changes will be saved\n");
        }

        if ($employeeId) {
            $employees = Employee::where('id', $employeeId)->with('employeeLeaveTypeDetail', 'employeeLeave')->get();
        } else {
            $employees = Employee::with('employeeLeaveTypeDetail', 'employeeLeave')->get();
        }

        $this->info("Recalculating leave balances for " . $employees->count() . " employee(s)...\n");

        $updated = 0;
        $errors = 0;

        DB::beginTransaction();

        try {
            foreach ($employees as $employee) {
                if (!$employee->employeeLeaveTypeDetail) {
                    continue;
                }

                $leaveDetails = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);
                
                if (!is_array($leaveDetails)) {
                    $this->error("Invalid data for employee {$employee->id}");
                    $errors++;
                    continue;
                }

                $hasChanges = false;

                foreach ($leaveDetails as &$leave) {
                    $leaveTypeId = $leave['leave_type_id'] ?? 0;
                    $allocated = (float)($leave['allocated_day'] ?? 0);
                    $oldRemaining = (float)($leave['remaining_allocated_day'] ?? 0);

                    // Calculate taken leave from approved leaves
                    $takenMinutes = $employee->employeeLeave
                        ->where('leave_type_id', $leaveTypeId)
                        ->where('status', 'approved')
                        ->sum('total_days');
                    
                    $takenDays = $takenMinutes / self::MINUTES_PER_DAY;
                    $newRemaining = $allocated - $takenDays;
                    $newRemaining = $newRemaining < 0 ? 0 : $newRemaining;

                    if (abs($oldRemaining - $newRemaining) > 0.01) {
                        $this->line("Employee {$employee->first_name} {$employee->last_name} - {$leave['leave_type']}:");
                        $this->line("  Old: {$oldRemaining} → New: " . round($newRemaining, 4));
                        $leave['remaining_allocated_day'] = $newRemaining;
                        $hasChanges = true;
                    }
                }

                if ($hasChanges) {
                    if (!$dryRun) {
                        $employee->employeeLeaveTypeDetail->leave_type_detail = serialize($leaveDetails);
                        $employee->employeeLeaveTypeDetail->save();
                    }
                    $updated++;
                }
            }

            if ($dryRun) {
                DB::rollBack();
                $this->info("\nDry run complete. {$updated} employee(s) would be updated.");
            } else {
                DB::commit();
                $this->info("\nSuccessfully updated {$updated} employee(s).");
            }

            if ($errors > 0) {
                $this->warn("{$errors} error(s) encountered.");
            }

            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
}
