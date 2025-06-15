<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('pegawai', function ($user) {
            return $user->role === 'pegawai';
        });

        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('pengelola', function ($user) {
            return $user->role === 'pengelola';
        });
    }
}
