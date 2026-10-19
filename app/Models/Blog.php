<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'image',
        'content',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'link',
        'author_id',
        'translations',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'translations' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(BlogImage::class)->orderBy('position')->orderBy('id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function localized(string $field, ?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        return (string) ($this->translations[$locale][$field]
            ?? $this->translations['es'][$field]
            ?? $this->getAttribute($field)
            ?? '');
    }

    public function coverUrl(): string
    {
        $image = $this->images->first();

        return $image ? route('blog.image', $image) : asset($this->image ?: config('blog.fallback_image'));
    }
}
