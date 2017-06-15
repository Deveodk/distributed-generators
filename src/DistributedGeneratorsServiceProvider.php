<?php

namespace DeveoDK\DistributedGenerators;

use Illuminate\Support\ServiceProvider;

class DistributedGeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('distributed.generators.php'),
        ]);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBundleGenerator();
    }
    /**
     * Register the make:bundle generators.
     */
    private function registerBundleGenerator()
    {
        $this->app->singleton('command.deveodk.bundle', function ($app) {
            return $app['DeveoDK\DistributedGenerators\Commands\BundleMakeCommand'];
        });
        $this->app->singleton('command.deveodk.bundle.model', function ($app) {
            return $app['DeveoDK\DistributedGenerators\Commands\Models\ModelMakeCommand'];
        });
        $this->app->singleton('command.deveodk.bundle.controller', function ($app) {
            return $app['DeveoDK\DistributedGenerators\Commands\Controllers\ControllerMakeCommand'];
        });
        $this->app->singleton('command.deveodk.bundle.event', function ($app) {
            return $app['DeveoDK\DistributedGenerators\Commands\Events\EventMakeCommand'];
        });
        $this->app->singleton('command.deveodk.bundle.listener', function ($app) {
            return $app['DeveoDK\DistributedGenerators\Commands\Listeners\ListenerMakeCommand'];
        });
        $this->app->singleton('command.deveodk.bundle.exception', function ($app) {
            return $app['DeveoDK\DistributedGenerators\Commands\Exceptions\ExceptionMakeCommand'];
        });
        $this->app->singleton('command.deveodk.bundle.route', function ($app) {
            return $app['DeveoDK\DistributedGenerators\Commands\RouteMakeCommand'];
        });
        $this->app->singleton('command.deveodk.bundle.transformer', function ($app) {
            return $app['DeveoDK\DistributedGenerators\Commands\Transformers\TransformerMakeCommand'];
        });
        $this->commands('command.deveodk.bundle');
        $this->commands('command.deveodk.bundle.model');
        $this->commands('command.deveodk.bundle.controller');
        $this->commands('command.deveodk.bundle.event');
        $this->commands('command.deveodk.bundle.listener');
        $this->commands('command.deveodk.bundle.exception');
        $this->commands('command.deveodk.bundle.route');
        $this->commands('command.deveodk.bundle.transformer');
    }
}