<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable para notificar inmediatamente a rogeriolucas14698@gmail.com
 * cuando un cliente solicita un servicio, presupuesto o mantenimiento.
 */
class ServiceInquiryMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public array $inquiryData
    ) {}

    public function envelope(): Envelope
    {
        // Enviamos a tu buzón oficial del dominio en IONOS (rogeriolucas@rogerlab.es),
        // que IONOS reenvía de forma transparente y autenticada a tu Gmail.
        // Si el remitente es tu propio dominio en IONOS, nunca será rechazado por SPF/DKIM.
        return new Envelope(
            to: [new Address('rogeriolucas@rogerlab.es', 'Rogerio Lucas - RogerLab')],
            replyTo: [new Address($this->inquiryData['email'], $this->inquiryData['name'])],
            subject: '⚡ Nueva solicitud de servicio freelance DAW: ' . ($this->inquiryData['service_name'] ?? 'Presupuesto general'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact.service-inquiry',
            with: [
                'name' => $this->inquiryData['name'],
                'email' => $this->inquiryData['email'],
                'phone' => $this->inquiryData['phone'] ?? 'No especificado',
                'service' => $this->inquiryData['service_name'] ?? 'Consulta general',
                'plan' => $this->inquiryData['plan_name'] ?? 'A determinar',
                'budget' => $this->inquiryData['budget'] ?? 'No indicado',
                'description' => $this->inquiryData['description'] ?? '',
                'submitted_at' => now()->format('d/m/Y H:i:s'),
            ],
        );
    }
}
