<?php

namespace LaraChimp\MangoRepo;

use LaraChimp\MangoRepo\Contracts\Repository;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\ServiceProvider as BaseProvider;

class MangoRepoServiceProvider extends BaseProvider
{
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
                __DIR__.'/../config/mango-repo.php' => config_path('mango-repo.php'),
            ], 'mango-repo-config');
        }

        $this->bootRepositories();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mango-repo.php', 'mango-repo');
        $this->registerAnnotations();
    }

    /**
     * We register Annotations here.
     *
     * @return void
     */
    protected function registerAnnotations()
    {
        AnnotationRegistry::registerFile(__DIR__.'/Annotations/EloquentModel.php');
    }

    /**
     * Boot Repositories when resolving them.
     *
     * @return void
     */
    protected function bootRepositories()
    {
        $this->app->resolving(function ($repo) {
            // This is a repo.
            if ($repo instanceof Repository) {
                // Boot the Repository.
                $repo->boot();
            }
        });
    }
}
