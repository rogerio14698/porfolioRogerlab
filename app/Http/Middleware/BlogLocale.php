<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->query('lang', $request->session()->get('blog.locale', 'es'));
        if (! in_array($locale, config('blog.locales'), true)) {
            $locale = 'es';
        }
        app()->setLocale($locale);
        $request->session()->put('blog.locale', $locale);

        return $next($request);
    }
}
