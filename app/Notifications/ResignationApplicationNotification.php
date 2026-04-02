<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResignationApplicationNotification extends Notification
{
    use Queueable;
    
    private $employeeName;
    private $resignationDate;
    private $noticeDate;
    private $description;
    private $companyName;
    private $departmentName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($employeeName, $resignationDate, $noticeDate, $description, $companyName, $departmentName)
    {
        $this->employeeName = $employeeName;
        $this->resignationDate = $resignationDate;
        $this->noticeDate = $noticeDate;
        $this->description = $description;
        $this->companyName = $companyName;
        $this->departmentName = $departmentName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello!')
            ->subject('New Resignation Application - ' . $this->employeeName)
            ->line('A new resignation application has been submitted by an employee.')
            ->line('**Employee Details:**')
            ->line('Name: ' . $this->employeeName)
            ->line('Company: ' . $this->companyName)
            ->line('Department: ' . $this->departmentName)
            ->line('Resignation Date: ' . $this->resignationDate)
            ->line('Notice Date: ' . $this->noticeDate)
            ->line('Description: ' . $this->description)
            ->line('Please review and take necessary action.')
            ->action('View Resignation Details', url('/core_hr/resignations'))
            ->line('Thank you for your attention.');
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
            'data' => $this->employeeName . ' has submitted a resignation application.',
            'link' => '/core_hr/resignations',
            'employee_name' => $this->employeeName,
            'resignation_date' => $this->resignationDate,
            'notice_date' => $this->noticeDate,
            'company_name' => $this->companyName,
            'department_name' => $this->departmentName
        ];
    }
}


















