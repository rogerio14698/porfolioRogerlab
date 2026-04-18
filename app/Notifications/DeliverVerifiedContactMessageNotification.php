<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeliverVerifiedContactMessageNotification extends Notification
{
    use Queueable;

    public function __construct(protected ContactMessage $contactMessage)
    {
    }

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Verified contact message: '.$this->contactMessage->subject)
            ->greeting('New verified contact message')
            ->line('A visitor confirmed ownership of the email address before delivery.')
            ->line('Name: '.$this->contactMessage->name)
            ->line('Email: '.$this->contactMessage->email)
            ->line('Subject: '.$this->contactMessage->subject)
            ->line('IP: '.($this->contactMessage->ip_address ?? 'unknown'))
            ->line('Submitted at: '.$this->contactMessage->created_at?->toDateTimeString())
            ->line('Message:')
            ->line($this->contactMessage->message);
    }
}