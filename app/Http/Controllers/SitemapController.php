<?php

namespace App\Http\Controllers;

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
                'loc' => route('articles'),
                'priority' => '0.9',
                'changefreq' => 'weekly',
            ],
            [
                'loc' => route('projects'),
                'priority' => '0.8',
                'changefreq' => 'monthly',
            ],
            [
                'loc' => route('juegos'),
                'priority' => '0.6',
                'changefreq' => 'monthly',
            ],
            [
                'loc' => route('juegos.ahorcado'),
                'priority' => '0.6',
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

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
