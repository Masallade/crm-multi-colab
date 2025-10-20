<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class FeedbackReminderNotification extends Notification
{
    protected $name, $nextAppraisalDate;

    public function __construct($name, $nextAppraisalDate)
    {
        $this->name = $name;
        $this->nextAppraisalDate = $nextAppraisalDate;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Appraisal Feedback Reminder')
            ->greeting("Dear {$this->name},")
            ->line("Your last feedback was submitted a year ago. Please submit your feedback again. Your new feedback cycle has now started.")
            ->action('Submit Feedback', route('employee_feedback'))
            ->line('Thank you!');
    }
}
