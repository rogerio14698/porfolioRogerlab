<?php

namespace App\Http\Controllers;

use App\Models\CarouselSetting;
use App\Models\Project;
use App\Models\Skill;
use App\Services\HomeCarousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function home(HomeCarousel $carousel)
    {
        $carouselSettings = CarouselSetting::current();

        return renderSection('home', __('portfolio.home_title'), __('portfolio.home_description'), 200, null, [
            'skills' => Skill::where('is_published', true)->orderBy('position')->orderBy('id')->get(),
            'discoveries' => $carousel->slides($carouselSettings),
            'carouselSettings' => $carouselSettings,
            ...$this->alternates('home'),
        ]);
    }

    public function index()
    {
        $projects = Project::published()->orderBy('position')->orderBy('id')->paginate(8)->withQueryString();
        $page = $projects->currentPage() > 1 ? ['page' => $projects->currentPage()] : [];

        return renderSection('projects', __('portfolio.page_title'), __('portfolio.intro'), 200, null, [
            'projects' => $projects,
            ...$this->alternates('projects', $page),
            'schemaJsonLd' => [
                '@context' => 'https://schema.org', '@type' => 'CollectionPage',
                'name' => __('portfolio.page_title'), 'description' => __('portfolio.intro'),
                'url' => route('projects', ['lang' => app()->getLocale()] + $page),
                'inLanguage' => app()->getLocale(),
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => $projects->getCollection()->values()->map(fn (Project $project, int $index) => [
                        '@type' => 'ListItem', 'position' => $projects->firstItem() + $index,
                        'url' => route('projects.show', ['project' => $project->slug, 'lang' => app()->getLocale()]),
                        'name' => $project->localized('title'),
                    ])->all(),
                ],
            ],
        ]);
    }

    public function show(Project $project)
    {
        abort_unless($project->is_published && $project->published_at?->lte(now()), 404);

        return $this->detail($project);
    }

    public function preview(Project $project)
    {
        return $this->detail($project, true);
    }

    private function detail(Project $project, bool $preview = false)
    {
        $title = $project->localized('seo_title') ?: $project->localized('title').' | RogerLab';
        $description = $project->localized('seo_description') ?: Str::limit($project->localized('summary'), 155);
        $alternates = $this->alternates('projects.show', ['project' => $project->slug], $project);

        return renderSection('project', $title, $description, 200, $preview ? 'noindex,nofollow' : null, [
            'project' => $project, 'preview' => $preview, 'ogImage' => $project->coverUrl(),
            ...$alternates,
            'schemaJsonLd' => [
                '@context' => 'https://schema.org', '@type' => 'CreativeWork',
                'name' => $project->localized('title'), 'description' => $description,
                'url' => $alternates['canonicalUrl'], 'image' => $project->coverUrl(),
                'inLanguage' => app()->getLocale(),
                'datePublished' => $project->published_at?->toIso8601String(),
                'dateModified' => $project->updated_at?->toIso8601String(),
                'keywords' => $project->technologyList(),
                'author' => ['@type' => 'Person', 'name' => config('seo.profile.name'), 'url' => config('seo.profile.portfolio')],
            ],
        ]);
    }

    private function alternates(string $route, array $parameters = [], ?Project $project = null): array
    {
        $links = [];
        foreach (config('blog.locales') as $locale) {
            if ($project && $locale !== 'es' && empty($project->translations[$locale]['title'])) {
                continue;
            }
            $links[$locale] = route($route, $parameters + ['lang' => $locale]);
        }
        $links['x-default'] = $links['es'];

        return ['canonicalUrl' => route($route, $parameters + ['lang' => app()->getLocale()]), 'hreflangLinks' => $links];
    }

    public function image(Request $request, Project $project, int $index)
    {
        $public = $project->is_published && $project->published_at?->lte(now());
        $owner = $request->user() && strcasecmp($request->user()->email, config('blog.owner_email')) === 0;
        abort_unless($public || $owner, 404);
        $image = $project->media[$index] ?? null;
        abort_unless($image && $image['disk'] === 'blog' && Storage::disk('blog')->exists($image['path']), 404);

        return response()->file(Storage::disk('blog')->path($image['path']), [
            'X-Content-Type-Options' => 'nosniff', 'Cache-Control' => 'no-store, private',
            'X-Robots-Tag' => $public ? 'index' : 'noindex, nofollow',
        ])->setPrivate();
    }
}
