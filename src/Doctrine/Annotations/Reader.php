<?php

namespace LaraChimp\MangoRepo\Doctrine\Annotations;

use Doctrine\Common\Cache\Cache;
use Illuminate\Support\Collection;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\Reader as ReaderContract;

class Reader
{
    /**
     * The Reader instance.
     *
     * @var ReaderContract
     */
    protected $reader;

    /**
     * Reader constructor.
     *
     * @param ReaderContract $annotationReader
     * @param Cache          $cacheDriver
     */
    public function __construct(ReaderContract $annotationReader, Cache $cacheDriver)
    {
        // Init Reader.
        $this->setReader($annotationReader, $cacheDriver);
    }

    /**
     * Set Reader.
     *
     * @param ReaderContract $annotationReader
     * @param Cache          $cacheDriver
     *
     * @return $this
     */
    public function setReader(ReaderContract $annotationReader, Cache $cacheDriver)
    {
        // Get if we are in debug mode.
        $debugMode = (bool) config('app.debug');

        $this->reader = new CachedReader($annotationReader, $cacheDriver, $debugMode);

        return $this;
    }

    /**
     * Get the Reader.
     *
     * @return ReaderContract
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * Get the class annotations for the given object.
     *
     * @param mixed $object
     *
     * @return Collection
     */
    public function getClassAnnotationsFor($object)
    {
        // Get Reflected class of the object.
        $reflClass = new \ReflectionClass(get_class($object));

        // Return class annotations.
        return collect($this->getReader()->getClassAnnotations($reflClass));
    }
}
