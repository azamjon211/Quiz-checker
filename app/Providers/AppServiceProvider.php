<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        RateLimiter::for('admin-login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip())
                ->response(fn() => back()
                    ->withErrors(['email' => 'Juda ko\'p urinish. 1 daqiqadan so\'ng qayta urinib ko\'ring.'])
                    ->withInput($request->only('email'))
                );
        });
        RateLimiter::for('admin-delete', function (Request $request) {
            return Limit::perMinute(30)
                ->by($request->ip())
                ->response(fn() => back()->with('error', 'Juda ko\'p o\'chirish so\'rovi. 1 daqiqadan so\'ng qayta urinib ko\'ring.'));
        });
    }
}
