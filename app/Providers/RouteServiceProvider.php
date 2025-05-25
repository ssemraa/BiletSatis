<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/redirect'; // ← ← ← ← ← ← ← ← ← Buraya ayarını yap

    public function boot(): void
    {
         parent::boot();

    Route::get('/redirect', function () {
        $user = Auth::user();
        if (!$user) return redirect('/login');

        return redirect($user->role === 'admin' ? '/admin' : '/user');
    });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
