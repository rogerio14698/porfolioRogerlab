<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SiteProfile extends Model
{
    public const TEXT_LIMITS = [
        'role' => 100, 'intro' => 220, 'availability' => 240,
        'contributions_title' => 60,
        'offer1_title' => 60, 'offer1_body' => 500,
        'offer2_title' => 60, 'offer2_body' => 500,
        'offer3_title' => 60, 'offer3_body' => 500,
        'bio_title' => 60, 'bio1' => 2000, 'bio2' => 2000,
        'research_title' => 60, 'research_body' => 1000, 'research_link' => 100,
        'photo_alt' => 200,
        'seo_title' => 80, 'seo_description' => 170,
        'about_seo_title' => 80, 'about_seo_description' => 170,
    ];

    protected $fillable = [
        'translations', 'research_enabled', 'research_route', 'photo_enabled', 'photo_path', 'photo_is_default',
    ];

    protected function casts(): array
    {
        return ['translations' => 'array', 'research_enabled' => 'boolean', 'photo_enabled' => 'boolean', 'photo_is_default' => 'boolean'];
    }

    public static function current(): self
    {
        return static::findOrFail(1);
    }

    public function proofProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'profile_project_evidence')
            ->withPivot('area')->orderBy('projects.position')->orderBy('projects.id');
    }

    public function projectsForArea(int $area): BelongsToMany
    {
        return $this->proofProjects()->withPivotValue('area', $area);
    }

    public function text(string $field, ?string $locale = null): string
    {
        return $this->translations[$locale ?? app()->getLocale()][$field] ?? '';
    }

    public function photoUrl(): ?string
    {
        if (! $this->photo_enabled) {
            return null;
        }

        return $this->photo_path
            ? route('profile.photo', ['version' => $this->updated_at->getTimestamp()])
            : ($this->photo_is_default ? asset('img/cv-foto-960-v1.webp') : null);
    }
}
