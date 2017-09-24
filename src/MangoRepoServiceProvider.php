<?php

namespace LaraChimp\MangoRepo;

use LaraChimp\MangoRepo\Contracts\Repository;
use Illuminate\Support\ServiceProvider as BaseProvider;
use LaraChimp\PineAnnotations\Support\Reader\AnnotationsReader;

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
            // Register Commands.
            $this->commands([
                Console\MakeCommand::class,
            ]);
        }

        $this->bootAnnotations();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
    }

    /**
     * Add annotation file to registry.
     *
     * @return void
     */
    protected function bootAnnotations()
    {
        $this->app->make(AnnotationsReader::class)
                  ->addFilesToRegistry(__DIR__.'/Annotations/EloquentModel.php');
    }

    /**
     * Boot Repositories when resolving them.
     *
     * @return void
     */
    protected function registerRepositories()
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
