<?php

namespace LaraChimp\MangoRepo;

use Doctrine\Common\Cache\Cache;
use LaraChimp\MangoRepo\Contracts\Repository;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use LaraChimp\MangoRepo\Doctrine\Annotations\Reader;
use Illuminate\Support\ServiceProvider as BaseProvider;
use Doctrine\Common\Annotations\Reader as ReaderContract;
use LaraChimp\MangoRepo\Doctrine\Cache\LaravelCacheDriver;

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

        $this->bootRepositories();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAnnotations();
    }

    /**
     * We register Annotations and
     * it's services here.
     *
     * @return void
     */
    protected function registerAnnotations()
    {
        // Annotation File registration.
        AnnotationRegistry::registerFile(__DIR__.'/Annotations/EloquentModel.php');

        // Contextually specify dependencies of our Annotation Reader.
        $this->app->when(Reader::class)->needs(ReaderContract::class)->give(function () {
            return new AnnotationReader();
        });

        $this->app->when(Reader::class)->needs(Cache::class)->give(function () {
            return new LaravelCacheDriver($this->app->make('cache'));
        });
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
