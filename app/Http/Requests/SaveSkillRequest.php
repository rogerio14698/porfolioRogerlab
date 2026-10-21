<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && strcasecmp($this->user()->email, config('blog.owner_email')) === 0;
    }

    public function rules(): array
    {
        $rules = [
            'position' => ['required', 'integer', 'min:0', 'max:10000'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'translations' => ['required', 'array:es,en,pt'],
        ];
        foreach (config('blog.locales') as $locale) {
            $rules["translations.$locale"] = ['present', 'array:label'];
            $rules["translations.$locale.label"] = [
                $locale === 'es' || $this->input('status') === 'published' ? 'required' : 'nullable',
                'string', 'max:100',
            ];
        }

        return $rules;
    }

    public function attributes(): array
    {
        $attributes = ['position' => __('portfolio.position')];
        foreach (config('blog.locales') as $locale) {
            $attributes["translations.$locale.label"] = __('portfolio.label').' ('.strtoupper($locale).')';
        }

        return $attributes;
    }
}
