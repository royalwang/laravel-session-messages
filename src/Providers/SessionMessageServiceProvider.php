<?php
namespace Tarach\LSM\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class SessionMessageServiceProvider extends IlluminateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \Tarach\LSM\SessionStorage\ISessionStorage::IOC_ID,
            function()
            {
                return app(\Tarach\LSM\SessionStorage\LaravelStorage::class);
            }
        );

        $this->app->singleton(
            \Tarach\LSM\Message\Collection::IOC_ID,
            function()
            {
                return app(\Tarach\LSM\Message\Collection::class);
            }
        );
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // if `php artisan vendor:publish` was used load "routes" from <app>/Http/tlsm.routes.php
        // instead of loading from <root>/vendor/<vendor>/<project>/config/routes.php
        $app_routes = app_path('Http/tlsm.routes.php');
        $local_routes = __DIR__ . '/../../config/routes.php';
        
        if(!$this->app->routesAreCached())
        {
            if(file_exists($app_routes))
            {
                $routes_file = $app_routes;
            } else {
                $routes_file = $local_routes;
            }
            include $routes_file;
        }

        // if `php artisan vendor:publish` was used load "views" from <root>/resources/vendor/tlsm
        // directory instead of loading from <root>/vendor/<vendor>/<project>/resources
        $root_resource_dir = base_path('resources/vendor/tlsm');
        
        if(file_exists($root_resource_dir))
        {
            $views_dir = $root_resource_dir.'/views';
        } else {
            $views_dir = realpath(__DIR__ . '/../../resources/views');
        }
        $this->loadViewsFrom($views_dir, 'tlsm');
        
        // publish all resources
        $this->publishes([
            $local_routes => $app_routes,
            __DIR__ . '/../../resources' => $root_resource_dir,
        ]);
    }
}
