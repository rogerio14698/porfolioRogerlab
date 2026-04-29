<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminContactMessageMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address('rogeriolucas@rogerlab.es', 'Roger Lab')],
            replyTo: [new Address($this->contactMessage->email, $this->contactMessage->name)],
            subject: 'Nueva consulta desde la Web: '.$this->contactMessage->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact.admin-contact-message',
            with: [
                'name' => $this->contactMessage->name,
                'email' => $this->contactMessage->email,
                'subject' => $this->contactMessage->subject,
                'message_body' => $this->contactMessage->message,
                'submitted_at' => optional($this->contactMessage->created_at)->format('d/m/Y H:i:s'),
                'ip_address' => $this->contactMessage->ip_address ?? 'unknown',
                'verification_badge' => 'Estado: Verificado por Turnstile/Honeypot',
            ],
        );
    }
}