<?php

namespace Danielthalmann\AuthUi;

use Danielthalmann\AuthUi\Console\Commands\CreateUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AuthUiServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->loadConfig();

        if (Config::get('authui.enabled')) {

            $this->commands(CreateUser::class);
            $this->registerComponents();
            $this->registerViews();

        }
    }

    protected function loadConfig()
    {
        $config_module_path = implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'config', 'authui.php']);

        // php artisan vendor:publish --tag=netmanager-config
        $this->publishes([
            $config_module_path => config_path('authui.php'),
        ], 'netmanager-config');

        if (! $this->app->configurationIsCached()) {
            if (Config::get('authui.enabled') === null) {
                Config::set('authui', (require $config_module_path));
            }
        }
    }

    protected function loadTranslate()
    {
        $lang_path = implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'resources', 'lang']);

        $this->loadTranslationsFrom($lang_path, 'authui');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        if (Config::get('authui.enabled')) {
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
        View::addNamespace('authui', implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'resources', 'views']));
    }

    public function registerComponents()
    {
        $components = include implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'resources', 'components.php']);
        foreach($components as $comp) {

            $fragments = explode ('\\', $comp);
            $name = Str::lower(last($fragments));
            Blade::component( 'ui-' . $name, $comp);

        }

    }

    public function registerRatelimiter()
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip())
                ->response(function () use ($request) {
                    if ($request->ajax())
                        return response()->json([
                            'message' => 'Too many attempts. Try again later.'
                        ], 429);
                    else
                        abort(429, 'Too many attempts. Try again later.');
                });
        });
    }

}
