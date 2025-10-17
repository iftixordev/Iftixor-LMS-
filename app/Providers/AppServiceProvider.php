<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\ServeCommand;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Override public_path helper
        $this->app->bind('path.public', function() {
            return base_path('public_html');
        });
    }
}