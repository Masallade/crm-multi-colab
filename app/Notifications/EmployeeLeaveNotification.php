<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeLeaveNotification extends Notification
{
    use Queueable;
    private $employee_name;
    private $total_days;
    private $start_date;
    private $end_date;
    private $leave_reason;
    private $fullActionBy;
    private $leaveType;
    private $status;
    private $teamLeadName;
    private $hrName;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($employee_name,$total_days,$start_date,$end_date,$leave_reason, $fullActionBy, $leaveType, $status, $teamLeadName, $hrName)
    {
        $this->employee_name = $employee_name;
        $this->total_days    = $total_days;
        $this->start_date    = $start_date;
        $this->end_date      = $end_date;
        $this->leave_reason  = $leave_reason;
        $this->fullActionBy  = $fullActionBy ?? 'System'; // fallback
        $this->leaveType = $leaveType;
        $this->status = $status;
        $this->teamLeadName = $teamLeadName;
        $this->hrName = $hrName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Assuming these properties are set when the notification is created
        $employeeName = $this->employee_name ?? 'Employee';
        $totalDays = $this->total_days ?? 'N/A';
        $startDate = $this->start_date ?? 'N/A';
        $endDate = $this->end_date ?? 'N/A';
        $leaveReason = $this->leave_reason ?? 'N/A';
        $fullActionBy = $this->fullActionBy ?? 'N/A';
        $leaveType = $this->leaveType ?? 'Leave';
        $status = $this->status ?? 'Pending';
        $teamLeadName = $this->teamLeadName ?? 'N/A';
        $hrName = $this->hrName ?? 'N/A';

        return (new MailMessage)
            ->subject('New Leave Application from ' . $employeeName)
            ->greeting('Dear ' . ($notifiable->first_name ?? 'User') . ',')
            ->line("$employeeName has applied for $leaveType ($totalDays days).")
            ->line("Dates: $startDate to $endDate")
            ->line("Reason: $leaveReason")
            ->line("Status: $status")
            ->line('This leave request will be reviewed and approved/rejected by:')
            ->line("- Team Lead: $teamLeadName")
            ->line("- HR: $hrName")
            ->action('View Leave Request', url('/timesheet/leaves'))
            ->line('Thank you.');
    }
    

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
