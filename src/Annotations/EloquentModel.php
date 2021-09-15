<?php

namespace LaraChimp\MangoRepo\Annotations;

/**
 * This Annotation is used to tell Laravel what Model to Use
 * when constructing an Eloquent Repository.
 *
 * @Annotation
 * @Target("CLASS")
 */
class EloquentModel
{
    /**
     * The Eloquent Model class we
     * use for the repository.
     *
     * @Required
     *
     * @var string
     */
    public $target;
}
