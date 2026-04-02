<?php

namespace App\Console\Commands;

use App\Models\leave;
use App\Models\User;
use App\Notifications\LeaveNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoRejectPendingLeaves extends Command
{
    protected $signature = 'leave:auto-reject-pending';

    protected $description = 'Auto-reject leave applications that have been pending for more than 2 days without review';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $cutoff = Carbon::now()->subDays(2);

        $pendingLeaves = leave::where('status', 'pending')
            ->where('created_at', '<', $cutoff)
            ->get();

        $count = 0;
        $systemRemark = 'Rejected by the system as 2 days went but it was not reviewed.';

        foreach ($pendingLeaves as $leave) {
            try {
                $existingRemarks = trim($leave->remarks ?? '');
                $remarks = $existingRemarks !== ''
                    ? $existingRemarks . ' ' . $systemRemark
                    : $systemRemark;

                $leave->update([
                    'status' => 'rejected',
                    'remarks' => $remarks,
                ]);

                $employeeId = $leave->employee_id;
                if ($employeeId) {
                    $notifiable = User::find($employeeId);
                    if ($notifiable) {
                        $notifiable->notify(new LeaveNotification(
                            'Your leave request has been automatically rejected. ' . $systemRemark
                        ));
                    }
                }

                $count++;
                Log::info('Auto-rejected pending leave', [
                    'leave_id' => $leave->id,
                    'employee_id' => $employeeId,
                ]);
            } catch (\Throwable $e) {
                Log::error('Auto-reject leave failed: ' . $e->getMessage(), [
                    'leave_id' => $leave->id,
                    'exception' => $e,
                ]);
            }
        }

        if ($count > 0) {
            $this->info("Auto-rejected {$count} pending leave(s).");
        }

        return 0;
    }
}
