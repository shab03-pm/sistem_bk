<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\AuthManager;

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
        // Register custom user provider for handling both User and Siswa models
        $this->app['auth']->provider('multi', function ($app, array $config) {
            return new \App\Auth\MultiModelUserProvider(
                $app['hash'],
                $config['model'] ?? \App\Models\User::class
            );
        });
    }
}
