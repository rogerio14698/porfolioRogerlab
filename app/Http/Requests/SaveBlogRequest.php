<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class SaveBlogRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $uploads = $this->input('uploads', []);
        if (is_array($uploads)) {
            foreach ($uploads as $index => $upload) {
                if (is_array($upload) && ! $this->hasFile("uploads.$index.file")
                    && empty(array_filter((array) ($upload['alt'] ?? [])))) {
                    unset($uploads[$index]);
                }
            }
            $this->merge(['uploads' => $uploads]);
        }
    }

    public function authorize(): bool
    {
        return $this->user() && strcasecmp($this->user()->email, config('blog.owner_email')) === 0;
    }

    public function rules(): array
    {
        $publishing = $this->input('status') === 'published';
        $rules = [
            'link' => ['required', 'string', 'max:160', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::notIn(['porfolio']), Rule::unique('blogs', 'link')->ignore($this->route('blog'))],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'translations' => ['required', 'array:es,en,pt'],
            'uploads' => ['nullable', 'array', 'max:'.config('blog.max_images')],
            'uploads.*' => ['array:file,alt'],
            'uploads.*.file' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('blog.max_image_kb'), 'dimensions:max_width=6000,max_height=6000'],
            'uploads.*.alt' => ['required_with:uploads.*.file', 'array:es,en,pt'],
            'existing_images' => ['nullable', 'array'],
            'existing_images.*' => ['array:alt'],
            'existing_images.*.alt' => ['required', 'array:es,en,pt'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['integer', Rule::exists('blog_images', 'id')->where('blog_id', $this->route('blog')?->id ?? 0)],
        ];
        foreach (config('blog.locales') as $locale) {
            $required = $publishing || $locale === 'es' ? 'required' : 'nullable';
            $rules["translations.$locale"] = ['required', 'array:title,content,seo_title,seo_description,seo_keywords'];
            $rules["translations.$locale.title"] = [$required, 'string', 'max:200'];
            $rules["translations.$locale.content"] = [$publishing ? 'required' : 'nullable', 'string', 'max:100000'];
            $rules["translations.$locale.seo_title"] = ['nullable', 'string', 'max:70'];
            $rules["translations.$locale.seo_description"] = ['nullable', 'string', 'max:160'];
            $rules["translations.$locale.seo_keywords"] = ['nullable', 'string', 'max:255'];
            $rules["uploads.*.alt.$locale"] = ['required_with:uploads.*.file', 'string', 'max:300'];
            $rules["existing_images.*.alt.$locale"] = ['required', 'string', 'max:300'];
        }
        $attributes["uploads.*.alt.$locale"] = __('blog.alt').' ('.strtoupper($locale).')';
        $attributes["existing_images.*.alt.$locale"] = __('blog.alt').' ('.strtoupper($locale).')';

        return $rules;
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            $blog = $this->route('blog');
            $ids = $blog ? $blog->images()->pluck('id')->all() : [];
            $removed = array_map('intval', (array) $this->input('remove_images', []));
            $retained = array_diff($ids, $removed);
            $existing = $this->input('existing_images', []);
            if (! is_array($existing)) {
                return;
            }
            foreach ($retained as $id) {
                if (! isset($existing[$id])) {
                    $validator->errors()->add('existing_images', __('blog.image_alts_required'));
                }
            }
            if (array_diff(array_map('intval', array_keys($existing)), $ids)) {
                $validator->errors()->add('existing_images', __('blog.invalid_images'));
            }
            if (count($retained) + count((array) $this->file('uploads', [])) > config('blog.max_images')) {
                $validator->errors()->add('uploads', __('blog.image_limit'));
            }
        }];
    }

    public function attributes(): array
    {
        $attributes = ['link' => __('blog.slug'), 'uploads.*.file' => __('blog.image')];
        foreach (config('blog.locales') as $locale) {
            foreach (['title', 'content', 'seo_title', 'seo_description', 'seo_keywords'] as $field) {
                $attributes["translations.$locale.$field"] = __('blog.'.$field).' ('.strtoupper($locale).')';
            }
        }

        return $attributes;
    }
}
