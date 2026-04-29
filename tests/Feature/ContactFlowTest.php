<?php

namespace Tests\Feature;

use App\Mail\AdminContactMessageMail;
use App\Models\ContactMessage;
use App\Notifications\VerifyContactMessageNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ContactFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_submission_creates_pending_message_and_sends_verification(): void
    {
        Notification::fake();

        $response = $this->post(route('contact.submit'), [
            'name' => 'Roger Lab',
            'subject' => 'Secure contact flow',
            'email' => 'rogeriolucas@rogerlab.es',
            'message' => 'This is a detailed message with enough length to pass validation.',
            'company' => '',
        ]);

        $response->assertRedirect(route('contact'));

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'rogeriolucas@rogerlab.es',
            'status' => ContactMessage::STATUS_PENDING,
            'spam_reason' => null,
        ]);

        Notification::assertSentOnDemand(VerifyContactMessageNotification::class);
    }

    public function test_signed_verification_marks_message_as_verified_and_notifies_admin(): void
    {
        Notification::fake();
        Mail::fake();

        $plainToken = 'verification-token-for-test';

        $contactMessage = ContactMessage::create([
            'name' => 'Roger Lab',
            'subject' => 'Verified delivery',
            'email' => 'rogeriolucas@rogerlab.es',
            'message' => 'This verified message should be delivered only after opt-in confirmation.',
            'status' => ContactMessage::STATUS_PENDING,
            'verification_token' => hash('sha256', $plainToken),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'contact.verify',
            now()->addMinutes(30),
            [
                'contactMessage' => $contactMessage->getKey(),
                'token' => $plainToken,
            ],
        );

        $response = $this->get($verificationUrl);

        $response->assertRedirect(route('contact'));

        $contactMessage->refresh();

        $this->assertSame(ContactMessage::STATUS_VERIFIED, $contactMessage->status);
        $this->assertNotNull($contactMessage->verified_at);
        $this->assertNull($contactMessage->verification_token);

        Mail::assertSent(AdminContactMessageMail::class, function (AdminContactMessageMail $mail) use ($contactMessage): bool {
            return $mail->hasTo('rogeriolucas@rogerlab.es')
                && $mail->hasReplyTo($contactMessage->email)
                && $mail->contactMessage->is($contactMessage);
        });
    }
}