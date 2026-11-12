<?php

namespace App\Http\Controllers;

use App\Models\ServiceSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * AdminServiceController:
 * Permite editar desde /admin/services todos los textos de la tienda,
 * servicios activos, modelos de cobro y correos de notificación.
 */
class AdminServiceController extends Controller
{
    /**
     * Muestra el formulario de edición de la tienda/servicios freelance.
     */
    public function edit()
    {
        $settings = ServiceSetting::current();

        return renderSection(
            'servicesAdmin',
            'Administrar Tienda & Servicios Freelance | RogerLab Admin',
            null,
            200,
            'noindex,nofollow',
            [
                'settings' => $settings,
            ]
        );
    }

    /**
     * Guarda los cambios de configuración y textos de la tienda.
     */
    public function update(Request $request): RedirectResponse
    {
        $settings = ServiceSetting::current();

        $validated = $request->validate([
            'notification_email' => ['required', 'email', 'max:180'],
            'whatsapp_number' => ['required', 'string', 'max:50'],
            'translations' => ['required', 'array'],
            'translations.es' => ['required', 'array'],
            'translations.en' => ['nullable', 'array'],
            'translations.pt' => ['nullable', 'array'],
            'services_catalog' => ['nullable', 'array'],
            'pricing_plans' => ['nullable', 'array'],
        ]);

        // Procesamiento y sanitización de las listas de features en el catálogo
        if (!empty($validated['services_catalog']) && is_array($validated['services_catalog'])) {
            foreach ($validated['services_catalog'] as &$serviceItem) {
                if (isset($serviceItem['features']) && is_string($serviceItem['features'])) {
                    // Dividir por saltos de línea para generar el array limpio
                    $serviceItem['features'] = array_values(array_filter(array_map('trim', explode("\n", $serviceItem['features']))));
                }
            }
        }

        // Procesamiento y sanitización de los items en los planes
        if (!empty($validated['pricing_plans']) && is_array($validated['pricing_plans'])) {
            foreach ($validated['pricing_plans'] as &$planItem) {
                if (isset($planItem['items']) && is_string($planItem['items'])) {
                    $planItem['items'] = array_values(array_filter(array_map('trim', explode("\n", $planItem['items']))));
                }
            }
        }

        $settings->fill($validated);
        $settings->save();

        return redirect()
            ->route('admin.services.edit', ['lang' => app()->getLocale()])
            ->with('status', 'Configuración de la tienda de servicios guardada correctamente.');
    }
}
