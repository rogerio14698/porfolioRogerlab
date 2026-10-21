<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselSetting extends Model
{
    public const DEFAULTS = [
        'mode' => 'automatic', 'autoplay' => true, 'interval_seconds' => 8,
        'pause_on_hover' => true, 'show_indicators' => true, 'max_slides' => 0,
    ];

    protected $fillable = ['mode', 'autoplay', 'interval_seconds', 'pause_on_hover', 'show_indicators', 'max_slides'];

    protected $attributes = self::DEFAULTS;

    protected function casts(): array
    {
        return [
            'autoplay' => 'boolean', 'pause_on_hover' => 'boolean', 'show_indicators' => 'boolean',
            'interval_seconds' => 'integer', 'max_slides' => 'integer',
        ];
    }

    public static function current(): self
    {
        return static::query()->orderBy('id')->first() ?? new static;
    }

    public function isManual(): bool
    {
        return $this->mode === 'manual';
    }
}
