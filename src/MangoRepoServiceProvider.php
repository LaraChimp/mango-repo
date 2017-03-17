<?php

namespace LaraChimp\MangoRepo;

use Illuminate\Database\Eloquent\Model;
use LaraChimp\MangoRepo\Contracts\Repository;
use Doctrine\Common\Annotations\FileCacheReader;
use Doctrine\Common\Annotations\AnnotationReader;
use LaraChimp\MangoRepo\Annotations\EloquentModel;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\ServiceProvider as BaseProvider;
use LaraChimp\MangoRepo\Exceptions\InvalidModelException;
use LaraChimp\MangoRepo\Exceptions\UnspecifiedModelException;

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
                __DIR__.'/../config/mango-repo.php' => config_path('mango-repo.php'),
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
        // Merge MangoRepo Config.
        $this->mergeConfigFrom(__DIR__.'/../config/mango-repo.php', 'mango-repo');

        // Register Annotations.
        $this->registerAnnotations();

        // Tell Laravel how to resolve Repos.
        $this->whenResolvingRepos();
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
     * We use this function to tell Laravel how to
     * resolve Repositories.
     *
     * @return void
     */
    protected function whenResolvingRepos()
    {
        $this->app->resolving(function ($repo) {
            // This is a repo.
            if ($repo instanceof Repository) {
                // Sets its Model.
                $repo->setModel($this->getEloquentModel($repo));
            }
        });
    }

    /**
     * Get the Eloquent Model used by the Repo.
     *
     * @param Repository $repo
     *
     * @return Model
     */
    protected function getEloquentModel(Repository $repo)
    {
        // Create Annotation Reader.
        $reader = $this->createAnnotationReader();

        // Get Reflected class of the Repo.
        $reflClass = new \ReflectionClass(get_class($repo));

        // Get Class Annotations.
        $classAnnotations = collect($reader->getClassAnnotations($reflClass))->reject(function ($item) {
            return ! ($item instanceof EloquentModel);
        });
        dump($classAnnotations);

        // No EloquentModel annotation class found.
        if ($classAnnotations->isEmpty()) {
            throw new UnspecifiedModelException('No Eloquent Model could referenced be for "'.get_class($repo).'". Specify the Eloquent Model for this repository using the "@EloquentModel" annotation on the class.');
        }

        // Get EloquentModel
        $eloquentModel = $this->app->make($classAnnotations->first()->target);
        dump($eloquentModel);

        // Not an instance of Model.
        if (! $eloquentModel instanceof Model) {
            throw new InvalidModelException('Specified model target for the repository "'.get_class($repo).'" is not an Eloquent Model instance.');
        }

        // Return EloquentModel.
        return $eloquentModel;
    }

    /**
     * Create and return Doctrine Annotation reader.
     *
     * @return FileCacheReader
     */
    private function createAnnotationReader()
    {
        // Specify debug mode.
        $debugMode = (bool) config('app.debug');
        // Get Cache Directory.
        $cacheDir = config('mango-repo.annotations_cache_dir');

        return new FileCacheReader(new AnnotationReader(), $cacheDir, $debugMode);
    }
}
