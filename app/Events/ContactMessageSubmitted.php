<?php

namespace App\Events;

use App\Models\ContactMessage;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactMessageSubmitted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public ContactMessage $contactMessage,
        public string $plainVerificationToken,
    ) {
    }
}