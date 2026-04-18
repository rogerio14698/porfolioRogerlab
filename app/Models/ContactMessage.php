<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_SPAM = 'spam';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'subject',
        'email',
        'message',
        'status',
        'verification_token',
        'verification_sent_at',
        'verified_at',
        'ip_address',
        'user_agent',
        'spam_reason',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'verification_sent_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }
}