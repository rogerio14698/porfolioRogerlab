<?php

return [
    'admin_email' => env('CONTACT_ADMIN_EMAIL', 'rogeriolucas14698@gmail.com'),
    'verification_expire_minutes' => (int) env('CONTACT_VERIFICATION_EXPIRE_MINUTES', 1440),
    'disposable_domains' => [
        '10minutemail.com',
        'dispostable.com',
        'fakeinbox.com',
        'getairmail.com',
        'guerrillamail.com',
        'maildrop.cc',
        'mailinator.com',
        'mintemail.com',
        'sharklasers.com',
        'temp-mail.org',
        'tempmail.com',
        'throwawaymail.com',
        'yopmail.com',
    ],
];