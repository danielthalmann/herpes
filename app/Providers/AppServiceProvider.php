<?php

namespace App\Providers;

use Danielthalmann\AuthUi\AuthUiServiceProvider;
use Danielthalmann\Herpes\HerpesServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(AuthUiServiceProvider::class);
        $this->app->register(HerpesServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
