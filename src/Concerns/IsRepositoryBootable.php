<?php

namespace LaraChimp\MangoRepo\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use LaraChimp\MangoRepo\Annotations\EloquentModel;
use LaraChimp\MangoRepo\Exceptions\InvalidModelException;
use LaraChimp\MangoRepo\Exceptions\UnspecifiedModelException;
use LaraChimp\PineAnnotations\Support\Reader\AnnotationsReader;

trait IsRepositoryBootable
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
    protected function getEloquentModel()
    {
        // We first check if Eloquent Model Target
        // is defined in the Repo class const.
        // and if so we resolve using const
        if (defined('static::TARGET')) {
            return $this->getEloquentModelByConst();
        }

        // We set the Model using Annotation.
        return $this->getEloquentModelByAnnotation();
    }

    /**
     * Using the Repositoristy class const to
     * build and set the Eloquent Model
     * to the class.
     *
     * @return Model
     */
    protected function getEloquentModelByConst()
    {
        // Get EloquentModel
        $eloquentModel = app()->make(static::TARGET);

        // Not an instance of Model.
        if (! $eloquentModel instanceof Model) {
            $this->sendInvalidModelException();
        }

        // Return EloquentModel.
        return $eloquentModel;
    }

    /**
     * Using the Repository annotation to
     * build and set the Eloquent Model
     * to the class.
     *
     * @return Model
     */
    protected function getEloquentModelByAnnotation()
    {
        return $this->findFirstEloquentModel($this->readEloquentModelClassAnnotations());
    }

    /**
     * Find the first Eloquent Model specified by the annotations.
     *
     * @param Collection $annotations
     *
     * @return Model
     */
    protected function findFirstEloquentModel(Collection $annotations)
    {
        // Get EloquentModel
        $eloquentModel = app()->make($annotations->first()->target);

        // Not an instance of Model.
        if (! $eloquentModel instanceof Model) {
            $this->sendInvalidModelException();
        }

        return $eloquentModel;
    }

    /**
     * Get EloquentModel annotations on the class.
     *
     * @return Collection
     */
    protected function readEloquentModelClassAnnotations()
    {
        $annotations = $this->getAnnotationsReader()
                            ->target('class')
                            ->read($this)
                            ->reject(function ($item) {
                                return ! ($item instanceof EloquentModel);
                            });

        // No EloquentModel annotation class found.
        if ($annotations->isEmpty()) {
            $this->sendUnspecifiedModelException();
        }

        return $annotations;
    }

    /**
     * Get the AnnotationsReader instance.
     *
     * @return AnnotationsReader
     */
    protected function getAnnotationsReader()
    {
        return app()->make(AnnotationsReader::class);
    }

    /**
     * We throw this when specified model is Invalid.
     *
     * @throws InvalidModelException
     */
    protected function sendInvalidModelException()
    {
        throw new InvalidModelException('Specified model target for the repository "'.get_class($this).'" is not a valid Eloquent Model instance.');
    }

    /**
     * We throw this when no model is specified on the class.
     *
     * @throws UnspecifiedModelException
     */
    protected function sendUnspecifiedModelException()
    {
        throw new UnspecifiedModelException('No Eloquent Model could be referenced be for "'.get_class($this).'". Specify the Eloquent Model for this repository using "const TARGET" or "@EloquentModel" annotation on the class.');
    }
}
