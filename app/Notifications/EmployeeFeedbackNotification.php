<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmployeeFeedbackNotification extends Notification
{
    protected $name, $department, $position, $appraisal, $assessment, $comment;

    public function __construct($name, $department, $position, $appraisal, $assessment, $comment)
    {
        $this->name = $name;
        $this->department = $department;
        $this->position = $position;
        $this->appraisal = $appraisal;
        $this->assessment = $assessment;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Employee Feedback Submitted')
            ->greeting('Dear Manager,')
            ->line("Employee **{$this->name}** from **{$this->department}** (Position: {$this->position}) has submitted feedback.")
            ->line("Duration of Appraisal: {$this->appraisal}")
            ->line("Self-Assessment: {$this->assessment}")
            ->line("Additional Comments: " . ($this->comment ?: 'No additional comments'))
            ->action('View Feedback', route('check_employee_feedback'))
            ->line('Thank you.');
    }
}
