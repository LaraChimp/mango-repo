<?php

namespace LaraChimp\MangoRepo\Traits;

use Illuminate\Database\Eloquent\Model;
use Doctrine\Common\Annotations\FileCacheReader;
use Doctrine\Common\Annotations\AnnotationReader;
use LaraChimp\MangoRepo\Annotations\EloquentModel;
use LaraChimp\MangoRepo\Exceptions\InvalidModelException;
use LaraChimp\MangoRepo\Exceptions\UnspecifiedModelException;

trait RepositoryBootable
{
    /**
     * Boot the Repository Class.
     *
     * @return self
     */
    public function boot()
    {
        $this->setModel($this->getEloquentModel());

        return $this;
    }

    /**
     * Get the Eloquent Model used by the Repo.
     *
     * @return Model
     */
    private function getEloquentModel()
    {
        // Create Annotation Reader.
        $reader = $this->createAnnotationReader();

        // Get Reflected class of the Repo.
        $reflClass = new \ReflectionClass(get_class($this));

        // Get Class Annotations.
        $classAnnotations = collect($reader->getClassAnnotations($reflClass))->reject(function ($item) {
            return ! ($item instanceof EloquentModel);
        });

        // No EloquentModel annotation class found.
        if ($classAnnotations->isEmpty()) {
            throw new UnspecifiedModelException('No Eloquent Model could referenced be for "'.get_class($this).'". Specify the Eloquent Model for this repository using the "@EloquentModel" annotation on the class.');
        }

        // Get EloquentModel
        $eloquentModel = app()->make($classAnnotations->first()->target);

        // Not an instance of Model.
        if (! $eloquentModel instanceof Model) {
            throw new InvalidModelException('Specified model target for the repository "'.get_class($this).'" is not an Eloquent Model instance.');
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
