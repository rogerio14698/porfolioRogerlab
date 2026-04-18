<?php

namespace App\Providers;

use App\Events\ContactMessageSubmitted;
use App\Listeners\SendContactVerificationNotification;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('contact-form', function (Request $request): Limit {
            return Limit::perHour(3)->by($request->ip());
        });

        Event::listen(
            ContactMessageSubmitted::class,
            SendContactVerificationNotification::class,
        );
    }
}
