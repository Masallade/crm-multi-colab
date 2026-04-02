<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResignationApprovedNotification extends Notification
{
    use Queueable;
    
    private $resignationDate;
    private $noticeDate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($resignationDate, $noticeDate)
    {
        $this->resignationDate = $resignationDate;
        $this->noticeDate = $noticeDate;
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
            ->subject('Resignation Request Approved')
            ->line('Your resignation request has been approved by both HR and Admin.')
            ->line('**Resignation Details:**')
            ->line('Resignation Date: ' . $this->resignationDate)
            ->line('Notice Date: ' . $this->noticeDate)
            ->line('Please ensure you complete all pending tasks and handover procedures before your last working day.')
            ->line('If you have any questions, please contact HR or your manager.')
            ->line('Thank you for your service.');
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
            'data' => 'Your resignation request has been approved.',
            'link' => '/core_hr/resignations',
            'resignation_date' => $this->resignationDate,
            'notice_date' => $this->noticeDate
        ];
    }
}


















