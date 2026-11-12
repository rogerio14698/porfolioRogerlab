<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo ServiceSetting:
 * Gestiona los textos editables, servicios y planes de la tienda/estudio freelance desde /admin.
 */
class ServiceSetting extends Model
{
    protected $fillable = [
        'translations',
        'services_catalog',
        'pricing_plans',
        'notification_email',
        'whatsapp_number',
    ];

    /**
     * Casts de atributos JSON a array nativo de PHP.
     */
    protected function casts(): array
    {
        return [
            'translations' => 'array',
            'services_catalog' => 'array',
            'pricing_plans' => 'array',
        ];
    }

    /**
     * Obtener el registro único de configuración actual.
     */
    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'translations' => [],
            'services_catalog' => [],
            'pricing_plans' => [],
            'notification_email' => 'rogeriolucas14698@gmail.com',
            'whatsapp_number' => '+34600000000',
        ]);
    }

    /**
     * Retorna un texto traducido según el locale activo.
     */
    public function text(string $field, ?string $locale = null): string
    {
        $lang = $locale ?? app()->getLocale();
        return $this->translations[$lang][$field] ?? $this->translations['es'][$field] ?? '';
    }
}
