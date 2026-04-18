<?php

namespace App\Listeners;

use App\Events\ContactMessageSubmitted;
use App\Notifications\VerifyContactMessageNotification;
use Illuminate\Support\Facades\Notification;

class SendContactVerificationNotification
{
    /**
     * Handle the event.
     */
    public function handle(ContactMessageSubmitted $event): void
    {
        Notification::route('mail', $event->contactMessage->email)
            ->notify(new VerifyContactMessageNotification(
                $event->contactMessage,
                $event->plainVerificationToken,
            ));

        $event->contactMessage->forceFill([
            'verification_sent_at' => now(),
        ])->save();
    }
}