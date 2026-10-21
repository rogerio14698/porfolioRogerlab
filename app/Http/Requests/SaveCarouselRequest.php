<?php

namespace App\Http\Requests;

use App\Models\Blog;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SaveCarouselRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mode' => ['required', 'in:automatic,manual'],
            'autoplay' => ['required', 'boolean'],
            'interval_seconds' => ['required', 'integer', 'min:2', 'max:60'],
            'pause_on_hover' => ['required', 'boolean'],
            'show_indicators' => ['required', 'boolean'],
            'max_slides' => ['required', 'integer', 'min:0', 'max:500'],
            'slides' => ['nullable', 'array', 'max:2000'],
            'slides.*.type' => ['required', 'in:project,blog'],
            'slides.*.id' => ['required', 'integer', 'min:1'],
            'slides.*.position' => ['required', 'integer', 'min:0', 'max:10000'],
            'slides.*.visible' => ['required', 'boolean'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }
            $slides = collect($this->input('slides', []));
            $keys = $slides->map(fn (array $slide) => $slide['type'].':'.$slide['id']);
            $known = [
                'project' => Project::whereIn('id', $slides->where('type', 'project')->pluck('id'))->pluck('id')->all(),
                'blog' => Blog::whereIn('id', $slides->where('type', 'blog')->pluck('id'))->pluck('id')->all(),
            ];
            $missing = $slides->contains(fn (array $slide) => ! in_array((int) $slide['id'], $known[$slide['type']], true));
            if ($missing || $keys->duplicates()->isNotEmpty()) {
                $validator->errors()->add('slides', __('portfolio.carousel_invalid_slides'));
            }
        }];
    }
}
