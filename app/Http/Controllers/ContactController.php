<?php

namespace App\Http\Controllers;

use App\Events\ContactMessageSubmitted;
use App\Http\Requests\ContactRequest;
use App\Mail\AdminContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function store(ContactRequest $request): RedirectResponse
    {
        $payload = $request->safe()->except(['cf-turnstile-response']);

        if ($this->honeypotTriggered($payload['company'] ?? null)) {
            ContactMessage::create($this->buildMessageAttributes(
                payload: $payload,
                request: $request,
                status: ContactMessage::STATUS_SPAM,
                spamReason: 'honeypot_triggered',
            ));

            return $this->contactResponse(
                type: 'success',
                message: 'Si el mensaje requiere accion, recibiras un correo de verificacion en unos minutos.',
            );
        }

        if (! $this->turnstilePassed($request)) {
            return back()
                ->withErrors(['security' => 'No se pudo validar la verificacion de seguridad. Intentalo de nuevo.'])
                ->withInput($request->except('cf-turnstile-response'));
        }

        if ($this->usesDisposableDomain($payload['email'])) {
            ContactMessage::create($this->buildMessageAttributes(
                payload: $payload,
                request: $request,
                status: ContactMessage::STATUS_SPAM,
                spamReason: 'disposable_email_domain',
            ));

            return back()
                ->withErrors(['email' => 'Usa una direccion de correo personal o profesional valida.'])
                ->withInput($request->except('cf-turnstile-response', 'company'));
        }

        $plainVerificationToken = Str::random(64);

        $contactMessage = ContactMessage::create($this->buildMessageAttributes(
            payload: $payload,
            request: $request,
            status: ContactMessage::STATUS_PENDING,
            verificationToken: hash('sha256', $plainVerificationToken),
        ));

        event(new ContactMessageSubmitted($contactMessage, $plainVerificationToken));

        return $this->contactResponse(
            type: 'success',
            message: 'Revisa tu correo y confirma el enlace de verificacion para que el mensaje llegue al administrador.',
        );
    }

    public function verify(Request $request, ContactMessage $contactMessage, string $token): RedirectResponse
    {
        if ($contactMessage->status === ContactMessage::STATUS_VERIFIED) {
            return $this->contactResponse(
                type: 'info',
                message: 'Este mensaje ya habia sido verificado anteriormente.',
            );
        }

        if ($contactMessage->status === ContactMessage::STATUS_SPAM) {
            abort(404);
        }

        if (! hash_equals((string) $contactMessage->verification_token, hash('sha256', $token))) {
            abort(403);
        }

        $contactMessage->forceFill([
            'status' => ContactMessage::STATUS_VERIFIED,
            'verified_at' => now(),
            'verification_token' => null,
            'spam_reason' => null,
        ])->save();

        Mail::send(new AdminContactMessageMail($contactMessage));

        return $this->contactResponse(
            type: 'success',
            message: 'Correo verificado correctamente. El Rogerio Lucas ya ha recibido tu mensaje.',
        );
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    protected function buildMessageAttributes(
        array $payload,
        Request $request,
        string $status,
        ?string $verificationToken = null,
        ?string $spamReason = null,
    ): array {
        return [
            'name' => trim((string) ($payload['name'] ?? '')),
            'subject' => trim((string) ($payload['subject'] ?? '')),
            'email' => Str::lower(trim((string) ($payload['email'] ?? ''))),
            'message' => trim((string) ($payload['message'] ?? '')),
            'status' => $status,
            'verification_token' => $verificationToken,
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 65535, ''),
            'spam_reason' => $spamReason,
        ];
    }

    protected function honeypotTriggered(?string $value): bool
    {
        return filled($value);
    }

    protected function usesDisposableDomain(string $email): bool
    {
        $domain = Str::afterLast(Str::lower($email), '@');

        return in_array($domain, config('contact.disposable_domains', []), true);
    }

    protected function turnstilePassed(Request $request): bool
    {
        if (app()->environment('testing')) {
            return true;
        }

        if (app()->isLocal() && blank(config('services.turnstile.secret_key'))) {
            return true;
        }

        $response = Http::asForm()
            ->timeout(10)
            ->post(config('services.turnstile.verify_url'), [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $request->string('cf-turnstile-response')->toString(),
                'remoteip' => $request->ip(),
            ]);

        if (! $response->ok()) {
            return false;
        }

        $result = $response->json();
        $expectedHost = parse_url((string) config('app.url'), PHP_URL_HOST);

        return (bool) data_get($result, 'success')
            && data_get($result, 'action') === 'contact'
            && (! $expectedHost || data_get($result, 'hostname') === $expectedHost);
    }

    protected function contactResponse(string $type, string $message): RedirectResponse
    {
        return redirect()
            ->route('contact')
            ->with('contact_status', $type)
            ->with('contact_message', $message);
    }
}