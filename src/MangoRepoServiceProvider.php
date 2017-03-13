<?php

namespace LaraChimp\MangoRepo;

use Illuminate\Support\ServiceProvider as BaseProvider;

class MangoRepoServiceProvider extends BaseProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Make sure we are running in console
        if ($this->app->runningInConsole()) {
            // Publish Config file.
            $this->publishes([
                __DIR__.'../config/mango-repo.php' => config_path('mango-repo.php')
            ], 'mango-repo-config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
