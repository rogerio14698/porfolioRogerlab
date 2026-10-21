<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $defaultLocale = $request->routeIs('blog', 'blog.show', 'blog.legacy', 'home', 'projects', 'projects.show')
            ? 'es'
            : $request->session()->get('blog.locale', 'es');
        $locale = $request->query('lang', $defaultLocale);
        if (! in_array($locale, config('blog.locales'), true)) {
            $locale = 'es';
        }
        app()->setLocale($locale);
        $request->session()->put('blog.locale', $locale);

        return $next($request);
    }
}
