<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [
            [
                'loc' => route('home'),
                'priority' => '1.0',
                'changefreq' => 'weekly',
            ],
            [
                'loc' => route('about'),
                'priority' => '0.8',
                'changefreq' => 'monthly',
            ],
            [
                'loc' => route('mi-periodo-practicas'),
                'priority' => '0.8',
                'changefreq' => 'monthly',
            ],
            [
                'loc' => route('blog'),
                'priority' => '0.9',
                'changefreq' => 'weekly',
            ],
            [
                'loc' => route('projects'),
                'priority' => '0.8',
                'changefreq' => 'monthly',
            ],
            [
                'loc' => route('contact'),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ],
            [
                'loc' => route('privacy-policy'),
                'priority' => '0.3',
                'changefreq' => 'yearly',
            ],
            [
                'loc' => route('terms-of-service'),
                'priority' => '0.3',
                'changefreq' => 'yearly',
            ],
            [
                'loc' => route('cookies-privacy'),
                'priority' => '0.3',
                'changefreq' => 'yearly',
            ],
        ];

        foreach (Blog::published()->select(['link', 'translations'])->cursor() as $blog) {
            foreach (config('blog.locales') as $locale) {
                if ($locale !== 'es' && empty($blog->translations[$locale]['title'])) {
                    continue;
                }
                $urls[] = [
                    'loc' => route('blog.show', ['blog' => $blog->link, 'lang' => $locale]),
                    'priority' => '0.7',
                    'changefreq' => 'monthly',
                ];
            }
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
