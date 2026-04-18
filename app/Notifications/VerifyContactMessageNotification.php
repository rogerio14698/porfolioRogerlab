<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyContactMessageNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected ContactMessage $contactMessage,
        protected string $plainVerificationToken,
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = URL::temporarySignedRoute(
            'contact.verify',
            now()->addMinutes((int) config('contact.verification_expire_minutes', 1440)),
            [
                'contactMessage' => $this->contactMessage->getKey(),
                'token' => $this->plainVerificationToken,
            ],
        );

        return (new MailMessage())
            ->subject('Confirm your contact request')
            ->greeting('Hello '.$this->contactMessage->name.',')
            ->line('We received your message on the portfolio contact form.')
            ->line('To prove that this email address belongs to you, confirm the request by clicking the button below.')
            ->action('Confirm contact request', $verificationUrl)
            ->line('If you did not submit this form, you can safely ignore this email.');
    }
}