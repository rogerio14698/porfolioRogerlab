<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\CarouselSetting;
use App\Models\CarouselSlide;
use App\Models\Project;
use Illuminate\Support\Collection;

class HomeCarousel
{
    public function slides(CarouselSetting $settings): Collection
    {
        $items = $settings->isManual() ? $this->manual() : $this->automatic();

        return $settings->max_slides > 0 ? $items->take($settings->max_slides)->values() : $items;
    }

    private function automatic(): Collection
    {
        return $this->interleave(
            Project::published()->where('is_featured', true)->orderBy('position')->orderBy('id')->get(),
            Blog::published()->with('images')->orderByDesc('published_at')->orderByDesc('id')->get(),
        );
    }

    private function manual(): Collection
    {
        $rows = CarouselSlide::where('is_visible', true)->orderBy('position')->orderBy('id')->get();
        $items = [
            'project' => Project::published()->whereIn('id', $rows->where('item_type', 'project')->pluck('item_id'))->get()->keyBy('id'),
            'blog' => Blog::published()->with('images')->whereIn('id', $rows->where('item_type', 'blog')->pluck('item_id'))->get()->keyBy('id'),
        ];

        return $rows->map(fn (CarouselSlide $row) => $items[$row->item_type]?->get($row->item_id))->filter()->values();
    }

    /**
     * Every project and article, ordered as the manual carousel will show them.
     * Content not yet saved in the panel is appended in automatic order.
     */
    public function candidates(): Collection
    {
        $rows = CarouselSlide::all()->keyBy(fn (CarouselSlide $row) => "$row->item_type:$row->item_id");
        $items = $this->interleave(
            Project::orderBy('position')->orderBy('id')->get(),
            Blog::with('images')->orderByDesc('published_at')->orderByDesc('id')->get(),
        );

        return $items->map(function (Project|Blog $item, int $index) use ($rows) {
            $type = $item instanceof Project ? 'project' : 'blog';
            $row = $rows->get("$type:$item->id");
            $public = $item->is_published && $item->published_at?->lte(now());

            return (object) [
                'type' => $type,
                'id' => $item->id,
                'item' => $item,
                'status' => ! $item->is_published ? 'draft' : ($public ? 'published' : 'scheduled'),
                'visible' => $row ? $row->is_visible : $public && ($type === 'blog' || $item->is_featured),
                'sort' => [$row ? 0 : 1, $row?->position ?? 0, $index],
            ];
        })->sort(fn (object $a, object $b) => $a->sort <=> $b->sort)->values();
    }

    private function interleave(Collection $projects, Collection $articles): Collection
    {
        $items = collect();
        for ($index = 0; $index < max($projects->count(), $articles->count()); $index++) {
            foreach ([$projects, $articles] as $group) {
                if (isset($group[$index])) {
                    $items->push($group[$index]);
                }
            }
        }

        return $items;
    }
}
