@foreach (config('blog.locales') as $locale)
    <details class="admin-language-panel" @if ($locale === app()->getLocale() || $errors->has("translations.$locale.*")) open @endif>
        <summary>{{ __('blog.'.$locale) }}</summary>
        <fieldset class="blog-language" lang="{{ $locale }}">
            <legend>{{ __('profile.admin.'.$group) }} · {{ strtoupper($locale) }}</legend>
            @foreach ($fields as $field => $label)
                @include('portfolio.field', [
                    'name' => "translations.$locale.$field",
                    'label' => __('profile.admin.'.$label).(str_starts_with($field, 'offer') ? ' · '.substr($field, 5, 1) : '').(str_starts_with($field, 'about_seo_') ? ' · '.__('profile.admin.about_seo') : ''),
                    'value' => $siteProfile->text($field, $locale),
                    'length' => \App\Models\SiteProfile::TEXT_LIMITS[$field],
                    'multiline' => \App\Models\SiteProfile::TEXT_LIMITS[$field] > 240,
                    'required' => !str_starts_with($field, 'research_') && $field !== 'photo_alt',
                ])
            @endforeach
        </fieldset>
    </details>
@endforeach
