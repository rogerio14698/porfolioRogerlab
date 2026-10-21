<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['translations', 'position', 'is_published'];

    protected function casts(): array
    {
        return ['translations' => 'array', 'is_published' => 'boolean', 'position' => 'integer'];
    }

    public function label(?string $locale = null): string
    {
        return $this->translations[$locale ?? app()->getLocale()]['label']
            ?? $this->translations['es']['label'] ?? '';
    }
}
