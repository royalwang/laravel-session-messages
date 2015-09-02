<?php
namespace Tarach\LSM\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class SessionMessageProvider extends IlluminateServiceProvider
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
        $this->app->bind(
            \Tarach\LSM\Message\Collection::IOC_ID,
            function()
            {
                return app(\Tarach\LSM\Message\Collection::class);
            }
        );
        
        $this->app->singleton(
            \Tarach\LSM\SessionStorage\ISessionStorage::IOC_ID,
            function()
            {
                return app(\Tarach\LSM\SessionStorage\LaravelStorage::class);
            }
        );

        $this->app->singleton(
            \Tarach\LSM\Config::IOC_ID,
            function()
            {
                return app(\Tarach\LSM\Config::class);
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
        $name = 'tlsm';

        // if `php artisan vendor:publish` was used load resources from $app_res_dir
        // including views, config and routes otherwise load from $tlum_res_dir 
        $app_res_dir = base_path('resources/vendor/'.$name);
        $tlum_res_dir = realpath(__DIR__ . '/../../resources');

        if(file_exists($app_res_dir))
        {
            $resource_dir = $app_res_dir;
        } else {
            $resource_dir = $tlum_res_dir;
        }

        // assign views prefix
        $this->loadViewsFrom($resource_dir.'/views', $name);

        // include routes
        if(!$this->app->routesAreCached())
        {
            include $resource_dir . '/config/routes.php';
        }

        // publish all resources
        $this->publishes([
            $tlum_res_dir => $app_res_dir
        ]);
    }
}
