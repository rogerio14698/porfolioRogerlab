<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'slug', 'translations', 'technologies', 'repository_url', 'website_url',
        'media', 'cover_index', 'position', 'is_featured', 'is_published', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'translations' => 'array', 'media' => 'array', 'position' => 'integer', 'cover_index' => 'integer',
            'is_featured' => 'boolean', 'is_published' => 'boolean', 'published_at' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function localized(string $field, ?string $locale = null): string
    {
        return (string) ($this->translations[$locale ?? app()->getLocale()][$field]
            ?? $this->translations['es'][$field] ?? '');
    }

    public function mediaUrl(int $index): string
    {
        $image = $this->media[$index] ?? null;

        return ! $image ? asset(config('blog.fallback_image'))
            : ($image['disk'] === 'asset' ? asset($image['path']) : route('projects.image', ['project' => $this, 'index' => $index]));
    }

    public function coverUrl(): string
    {
        return $this->mediaUrl($this->cover_index ?? 0);
    }

    public function imageAlt(int $index): string
    {
        return $this->media[$index]['alt'][app()->getLocale()] ?? ''
            ?: $this->localized('image_alt');
    }

    public function galleryIndexes(): array
    {
        return array_values(array_filter(array_keys($this->media ?? []),
            fn (int $index) => ! ($this->media[$index]['is_logo'] ?? false)));
    }

    public function technologyList(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/u', $this->technologies ?? ''))));
    }
}
