<?php

namespace App\Http\Controllers;

use Carbon\CarbonImmutable;

class SitemapController extends Controller
{
    public function index()
    {
        $lastmod = CarbonImmutable::now()->toAtomString();

        $urls = [
            [
                'loc' => route('home'),
                'priority' => '1.0',
                'changefreq' => 'weekly',
                'lastmod' => $lastmod,
            ],
            [
                'loc' => route('about'),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => $lastmod,
            ],
            [
                'loc' => route('articles'),
                'priority' => '0.9',
                'changefreq' => 'weekly',
                'lastmod' => $lastmod,
            ],
            [
                'loc' => route('projects'),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => $lastmod,
            ],
            [
                'loc' => route('juegos'),
                'priority' => '0.6',
                'changefreq' => 'monthly',
                'lastmod' => $lastmod,
            ],
            [
                'loc' => route('juegos.ahorcado'),
                'priority' => '0.6',
                'changefreq' => 'monthly',
                'lastmod' => $lastmod,
            ],
            [
                'loc' => route('contact'),
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'lastmod' => $lastmod,
            ],
            [
                'loc' => route('privacy-policy'),
                'priority' => '0.3',
                'changefreq' => 'yearly',
                'lastmod' => $lastmod,
            ],
            [
                'loc' => route('terms-of-service'),
                'priority' => '0.3',
                'changefreq' => 'yearly',
                'lastmod' => $lastmod,
            ],
            [
                'loc' => route('cookies-privacy'),
                'priority' => '0.3',
                'changefreq' => 'yearly',
                'lastmod' => $lastmod,
            ],
        ];

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
