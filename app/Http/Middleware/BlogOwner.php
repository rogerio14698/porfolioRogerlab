<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->guest(route('login', ['lang' => app()->getLocale()]));
        }
        abort_unless(
            strcasecmp($request->user()->email, config('blog.owner_email')) === 0,
            403,
        );

        return $next($request);
    }
}
