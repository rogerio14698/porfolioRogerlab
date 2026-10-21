<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class SaveProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && strcasecmp($this->user()->email, config('blog.owner_email')) === 0;
    }

    public function rules(): array
    {
        $rules = [
            'slug' => ['required', 'string', 'max:160', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('projects')->ignore($this->route('project'))],
            'position' => ['required', 'integer', 'min:0', 'max:10000'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'is_featured' => ['sometimes', 'boolean'],
            'technologies' => ['nullable', 'string', 'max:2000'],
            'repository_url' => ['nullable', 'url:http,https', 'max:2048'],
            'website_url' => ['nullable', 'url:http,https', 'max:2048'],
            'translations' => ['required', 'array:es,en,pt'],
            'uploads' => ['nullable', 'array', 'max:20'],
            'uploads.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120', 'dimensions:max_width=6000,max_height=6000'],
            'remove_media' => ['nullable', 'array'],
            'remove_media.*' => ['integer', 'distinct', Rule::in(array_keys($this->route('project')?->media ?? []))],
            'media_alt' => ['nullable', 'array'],
            'media_alt.*' => ['array:es,en,pt'],
            'cover_index' => ['nullable', Rule::in([...array_keys($this->route('project')?->media ?? []), 'new'])],
        ];
        foreach (config('blog.locales') as $locale) {
            $publishing = $this->input('status') === 'published';
            $rules["translations.$locale"] = ['present', 'array:title,summary,content,image_alt,category,period,seo_title,seo_description'];
            foreach (['title' => 200, 'summary' => 600, 'content' => 100000, 'image_alt' => 300, 'category' => 100, 'period' => 100, 'seo_title' => 70, 'seo_description' => 160] as $field => $length) {
                $rules["translations.$locale.$field"] = [
                    ($field === 'title' && $locale === 'es') || ($publishing && in_array($field, ['title', 'summary', 'content', 'image_alt'])) ? 'required' : 'nullable',
                    'string', "max:$length",
                ];
            }
            $rules["media_alt.*.$locale"] = ['nullable', 'string', 'max:300'];
        }

        return $rules;
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            $retained = count($this->route('project')?->media ?? []) - count((array) $this->input('remove_media', []));
            if ($retained + count((array) $this->file('uploads', [])) > 20) {
                $validator->errors()->add('uploads', __('portfolio.image_limit'));
            }
            $cover = $this->input('cover_index');
            if (($cover === 'new' && ! $this->hasFile('uploads')) ||
                ($cover !== null && in_array($cover, (array) $this->input('remove_media', [])))) {
                $validator->errors()->add('cover_index', __('portfolio.invalid_cover'));
            }
            $alts = $this->input('media_alt', []);
            if (is_array($alts) && array_diff(array_keys($alts), array_keys($this->route('project')?->media ?? []))) {
                $validator->errors()->add('media_alt', __('blog.invalid_images'));
            }
        }];
    }

    public function attributes(): array
    {
        $attributes = [];
        foreach (['slug', 'position', 'technologies', 'repository_url', 'website_url', 'uploads'] as $field) {
            $attributes[$field] = __('portfolio.'.$field);
        }
        foreach (config('blog.locales') as $locale) {
            foreach (['title', 'summary', 'content', 'image_alt', 'category', 'period', 'seo_title', 'seo_description'] as $field) {
                $attributes["translations.$locale.$field"] = __('portfolio.'.$field).' ('.strtoupper($locale).')';
            }
        }

        return $attributes;
    }
}
