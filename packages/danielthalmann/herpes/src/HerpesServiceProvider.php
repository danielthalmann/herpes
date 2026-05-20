<?php

namespace Danielthalmann\Herpes;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class HerpesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->loadConfig();

        if (Config::get('herpes.enabled')) {

            $this->registerComponents();
            $this->loadMigrations();
            $this->registerViews();


        }
    }

    protected function loadConfig()
    {
        $config_module_path = implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'config', 'herpes.php']);

        // php artisan vendor:publish --tag=netmanager-config
        $this->publishes([
            $config_module_path => config_path('herpes.php'),
        ], 'netmanager-config');

        if (! app()->configurationIsCached()) {
            if (Config::get('herpes.enabled') === null) {
                Config::set('herpes', (require $config_module_path));
            }
        }
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'database', 'migrations']));
        $this->publishes([
            implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'database', 'migrations']) => database_path('migrations'),
        ], 'qsimport-migration');
    }

    protected function loadTranslate()
    {
        $lang_path = implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'resources', 'lang']);

        $this->loadTranslationsFrom($lang_path, 'herpes');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        if (Config::get('herpes.enabled')) {
            $this->registerRoutes();
            $this->loadTranslate();
            $this->registerRatelimiter();
        }
    }

    public function registerRoutes()
    {
        if (! app()->routesAreCached()) {
            require implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'routes', 'web.php']);
        }
    }

    public function registerViews()
    {
        View::addNamespace('herpes', implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'resources', 'views']));
    }

    public function registerComponents()
    {
        $components = include implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'resources', 'components.php']);
        foreach ($components as $comp) {

            $fragments = explode('\\', $comp);
            $name = Str::lower(last($fragments));
            Blade::component('herpes.' . $name, $comp);

        }
    }

    public function registerRatelimiter()
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip())
                ->response(function () use ($request) {
                    if ($request->ajax()) {
                        return response()->json([
                            'message' => 'Too many attempts. Try again later.',
                        ], 429);
                    } else {
                        abort(429, 'Too many attempts. Try again later.');
                    }
                });
        });
    }
}
