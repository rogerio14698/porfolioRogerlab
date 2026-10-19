<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $articles = Blog::published()->with('images')->orderByDesc('published_at')->paginate(8)->withQueryString();
        $page = $articles->currentPage() > 1 ? $articles->currentPage() : null;
        $hreflangLinks = collect(config('blog.locales'))->mapWithKeys(fn ($locale) => [
            $locale => route('blog', array_filter(['lang' => $locale, 'page' => $page])),
        ])->all();
        $hreflangLinks['x-default'] = $hreflangLinks['es'];

        return renderSection('blog', __('blog.page_title'), __('blog.intro'), 200, null, [
            'articles' => $articles,
            'ogImage' => asset(config('blog.social_image')),
            'ogImageWidth' => 1200,
            'ogImageHeight' => 630,
            'canonicalUrl' => $hreflangLinks[app()->getLocale()],
            'hreflangLinks' => $hreflangLinks,
        ]);
    }

    public function redirectLegacy(Request $request)
    {
        if (! Blog::published()->where('link', 'portfolio')->exists()) {
            // Slug migration not applied yet: keep serving the post at its old URL.
            return $this->show(Blog::where('link', 'porfolio')->firstOrFail());
        }

        return redirect()->route('blog.show', array_merge($request->query(), ['blog' => 'portfolio']), 301);
    }

    public function show(Blog $blog)
    {
        abort_unless($blog->is_published && $blog->published_at?->isPast(), 404);

        return $this->article($blog);
    }

    public function preview(Blog $blog)
    {
        return $this->article($blog, true);
    }

    private function article(Blog $blog, bool $preview = false)
    {
        $blog->load('images');
        $title = $blog->localized('seo_title') ?: $blog->localized('title');
        $description = $blog->localized('seo_description') ?: Str::limit($blog->localized('content'), 155);
        $canonical = route('blog.show', ['blog' => $blog->link, 'lang' => app()->getLocale()]);
        $images = $blog->images->map(fn (BlogImage $image) => route('blog.image', $image))->all();
        $hreflangLinks = [];
        foreach (config('blog.locales') as $locale) {
            if ($locale !== 'es' && empty($blog->translations[$locale]['title'])) {
                continue;
            }
            $hreflangLinks[$locale] = route('blog.show', ['blog' => $blog->link, 'lang' => $locale]);
        }
        $hreflangLinks['x-default'] = $hreflangLinks['es'];

        return renderSection('blog', $title, $description, 200, $preview ? 'noindex,nofollow' : null, [
            'article' => $blog,
            'preview' => $preview,
            'metaKeywords' => $blog->localized('seo_keywords'),
            'ogImage' => $blog->coverUrl(),
            'ogType' => 'article',
            'canonicalUrl' => $canonical,
            'hreflangLinks' => $hreflangLinks,
            'schemaJsonLd' => [
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $blog->localized('title'),
                'description' => $description,
                'url' => $canonical,
                'image' => $images ?: [$blog->coverUrl()],
                'inLanguage' => app()->getLocale(),
                'author' => ['@type' => 'Person', 'name' => config('seo.profile.name'), 'url' => config('seo.profile.portfolio')],
                'datePublished' => $blog->published_at?->toIso8601String(),
                'dateModified' => $blog->updated_at?->toIso8601String(),
            ],
        ]);
    }

    public function image(Request $request, BlogImage $image)
    {
        $blog = $image->blog;
        $public = $blog->is_published && $blog->published_at?->isPast();
        $owner = $request->user() && strcasecmp($request->user()->email, config('blog.owner_email')) === 0;
        abort_unless($public || $owner, 404);
        abort_unless(Storage::disk('blog')->exists($image->path), 404);

        return response()->file(Storage::disk('blog')->path($image->path), [
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'no-store, private',
            'X-Robots-Tag' => $public ? 'index' : 'noindex, nofollow',
        ])->setPrivate();
    }
}
