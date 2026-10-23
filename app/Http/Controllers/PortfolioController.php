<?php

namespace App\Http\Controllers;

use App\Models\CarouselSetting;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SiteProfile;
use App\Services\HomeCarousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function home(HomeCarousel $carousel)
    {
        $carouselSettings = CarouselSetting::current();
        $profile = SiteProfile::current();

        return renderSection('home', $profile->text('seo_title'), $profile->text('seo_description'), 200, null, [
            'siteProfile' => $profile,
            'skills' => Skill::where('is_published', true)->orderBy('position')->orderBy('id')->get(),
            'proofProjects' => $profile->proofProjects()->published()->get()->groupBy('pivot.area'),
            'discoveries' => $carousel->slides($carouselSettings),
            'carouselSettings' => $carouselSettings,
            'ogImage' => $profile->photoUrl() ?? asset('img/favicon/android-chrome-512x512.png'),
            'schemaJsonLd' => $this->profileSchema($profile, 'home'),
            ...$this->alternates('home'),
        ]);
    }

    public function about()
    {
        $profile = SiteProfile::current();

        return renderSection('about', $profile->text('about_seo_title'), $profile->text('about_seo_description'), 200, null, [
            'siteProfile' => $profile,
            'skills' => Skill::where('is_published', true)->orderBy('position')->orderBy('id')->get(),
            'ogImage' => $profile->photoUrl() ?? asset('img/favicon/android-chrome-512x512.png'),
            'schemaJsonLd' => $this->profileSchema($profile, 'about'),
            ...$this->alternates('about'),
        ]);
    }

    private function profileSchema(SiteProfile $profile, string $route): array
    {
        $identity = config('seo.profile');
        $personId = $identity['portfolio'].'#person';
        $websiteId = $identity['portfolio'].'#website';
        $url = route($route, ['lang' => app()->getLocale()]);
        $person = [
            '@type' => 'Person', '@id' => $personId, 'name' => $identity['name'],
            'url' => $identity['portfolio'], 'jobTitle' => $profile->text('role'),
            'description' => $profile->text('bio1'),
            'sameAs' => [$identity['linkedin'], $identity['github']],
            'knowsAbout' => Skill::where('is_published', true)->orderBy('position')->orderBy('id')->get()
                ->map(fn (Skill $skill) => $skill->label())->all(),
            'address' => ['@type' => 'PostalAddress', 'addressLocality' => config('seo.city'),
                'addressRegion' => config('seo.region'), 'addressCountry' => 'ES'],
        ];
        if ($profile->photoUrl()) {
            $person['image'] = $profile->photoUrl();
        }
        $graph = [
            $person,
            ['@type' => 'WebSite', '@id' => $websiteId, 'name' => 'RogerLab',
                'url' => $identity['portfolio'], 'author' => ['@id' => $personId]],
            ['@type' => $route === 'about' ? 'AboutPage' : 'WebPage', '@id' => $url.'#page',
                'url' => $url, 'name' => $profile->text($route === 'about' ? 'about_seo_title' : 'seo_title'),
                'description' => $profile->text($route === 'about' ? 'about_seo_description' : 'seo_description'),
                'inLanguage' => app()->getLocale(), 'about' => ['@id' => $personId],
                'isPartOf' => ['@id' => $websiteId], 'dateModified' => $profile->updated_at->toIso8601String()],
        ];
        if ($route === 'home') {
            foreach (range(1, 3) as $index) {
                $graph[] = [
                    '@type' => 'Service', '@id' => $url."#service-$index",
                    'name' => $profile->text("offer{$index}_title"),
                    'description' => $profile->text("offer{$index}_body"),
                    'provider' => ['@id' => $personId], 'areaServed' => 'Worldwide',
                    'url' => route('contact'),
                ];
            }
        }

        return ['@context' => 'https://schema.org', '@graph' => $graph];
    }

    public function photo()
    {
        $profile = SiteProfile::current();
        abort_unless($profile->photo_enabled && $profile->photo_path && Storage::disk('blog')->exists($profile->photo_path), 404);

        return response()->file(Storage::disk('blog')->path($profile->photo_path), [
            'Content-Type' => 'image/webp', 'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'no-store, private',
        ])->setPrivate();
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
