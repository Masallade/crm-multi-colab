<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppraisalEvaluatorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $employeeName;
    protected $employeeDesignation;
    protected $employeeDepartment;
    protected $sectionName;

    public function __construct($employeeName, $employeeDesignation, $employeeDepartment, $sectionName)
    {
        $this->employeeName = $employeeName;
        $this->employeeDesignation = $employeeDesignation;
        $this->employeeDepartment = $employeeDepartment;
        $this->sectionName = $sectionName;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Appraisal Evaluation Required')
            ->greeting('Hello!')
            ->line("You have been assigned to evaluate {$this->employeeName} ({$this->employeeDesignation}, {$this->employeeDepartment})")
            ->line("Section: {$this->sectionName}")
            ->action('Evaluate Now', route('performance.appraisal.index'))
            ->line('Thank you for your cooperation!');
    }

    public function toArray($notifiable)
    {
        return [
            'data' => "You have been assigned to evaluate {$this->employeeName} for section: {$this->sectionName}",
            'link' => route('performance.appraisal.index'),
        ];
    }
} 