<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    public const HOME = '/';

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(200)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/V1/api.php'));

            Route::middleware(['web', 'auth', 'role:admin|developer|manager'])
                ->namespace($this->namespace)
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}