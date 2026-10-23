<?php

namespace App\Http\Requests;

use App\Models\SiteProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && strcasecmp($this->user()->email, config('blog.owner_email')) === 0;
    }

    public function rules(): array
    {
        $rules = [
            'translations' => ['required', 'array:es,en,pt'],
            'research_enabled' => ['required', 'boolean'],
            'photo_enabled' => ['required', 'boolean'],
            'research_route' => ['required', Rule::in(['about', 'projects', 'blog', 'contact'])],
            'photo' => [Rule::requiredIf(fn () => $this->boolean('photo_enabled') && ! SiteProfile::current()->photo_is_default && ! SiteProfile::current()->photo_path),
                'nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120', 'dimensions:max_width=6000,max_height=6000'],
        ];
        foreach (range(1, 3) as $index) {
            $rules["offer{$index}_project_ids"] = ['sometimes', 'array'];
            $rules["offer{$index}_project_ids.*"] = ['required', 'integer', 'distinct', Rule::exists('projects', 'id')];
        }
        foreach (config('blog.locales') as $locale) {
            $rules["translations.$locale"] = ['required', 'array:'.implode(',', array_keys(SiteProfile::TEXT_LIMITS))];
            foreach (SiteProfile::TEXT_LIMITS as $field => $limit) {
                $optional = str_starts_with($field, 'research_') && ! $this->boolean('research_enabled');
                $optional = $optional || ($field === 'photo_alt' && ! $this->boolean('photo_enabled') && ! $this->hasFile('photo'));
                $rules["translations.$locale.$field"] = [$optional ? 'nullable' : 'required', 'string', "max:$limit"];
            }
        }

        return $rules;
    }

    public function attributes(): array
    {
        $labels = [
            'role' => 'role', 'intro' => 'intro_text', 'availability' => 'availability',
            'contributions_title' => 'contributions', 'bio_title' => 'heading',
            'bio1' => 'bio1', 'bio2' => 'bio2', 'research_title' => 'research',
            'research_body' => 'body', 'research_link' => 'link_text', 'photo_alt' => 'photo_alt',
            'seo_title' => 'seo_title', 'seo_description' => 'seo_description',
            'about_seo_title' => 'seo_title', 'about_seo_description' => 'seo_description',
        ];
        foreach (range(1, 3) as $index) {
            $labels["offer{$index}_title"] = 'heading';
            $labels["offer{$index}_body"] = 'body';
        }
        $attributes = [];
        foreach (range(1, 3) as $index) {
            $attributes["offer{$index}_project_ids"] = __('profile.admin.proof');
            $attributes["offer{$index}_project_ids.*"] = __('profile.admin.proof');
        }
        foreach (config('blog.locales') as $locale) {
            foreach ($labels as $field => $label) {
                $attributes["translations.$locale.$field"] = __('profile.admin.'.$label).' ('.strtoupper($locale).')';
            }
        }

        return $attributes;
    }
}
