<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveCarouselRequest;
use App\Models\CarouselSetting;
use App\Models\CarouselSlide;
use App\Services\HomeCarousel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AdminCarouselController extends Controller
{
    public function edit(HomeCarousel $carousel)
    {
        $settings = CarouselSetting::current();

        return renderSection('carouselAdmin', __('portfolio.carousel_admin'), null, 200, 'noindex,nofollow', [
            'settings' => $settings,
            'candidates' => $carousel->candidates(),
            'visibleCount' => $carousel->slides($settings)->count(),
        ]);
    }

    public function update(SaveCarouselRequest $request): RedirectResponse
    {
        $data = $request->validated();
        DB::transaction(function () use ($data): void {
            $settings = CarouselSetting::query()->orderBy('id')->lockForUpdate()->first() ?? new CarouselSetting;
            $settings->fill(collect($data)->only(array_keys(CarouselSetting::DEFAULTS))->all())->save();

            CarouselSlide::query()->delete();
            collect($data['slides'] ?? [])->values()
                ->map(fn (array $slide, int $index) => $slide + ['index' => $index])
                ->sortBy([['position', 'asc'], ['index', 'asc']])
                ->values()
                ->each(fn (array $slide, int $position) => CarouselSlide::create([
                    'item_type' => $slide['type'], 'item_id' => $slide['id'],
                    'position' => $position, 'is_visible' => (bool) $slide['visible'],
                ]));
        });

        return redirect()->route('admin.carousel.edit', ['lang' => app()->getLocale()])
            ->with('status', __('portfolio.saved'));
    }
}
