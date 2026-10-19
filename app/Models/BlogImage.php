<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogImage extends Model
{
    protected $fillable = ['path', 'alt', 'position'];

    protected function casts(): array
    {
        return ['alt' => 'array'];
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function localizedAlt(): string
    {
        return $this->alt[app()->getLocale()] ?? $this->alt['es'] ?? '';
    }
}
