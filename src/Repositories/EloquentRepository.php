<?php

namespace LaraChimp\MangoRepo\Repositories;

use LaraChimp\MangoRepo\Concerns;
use LaraChimp\MangoRepo\Contracts\Repository;

abstract class EloquentRepository implements Repository
{
    use Concerns\IsRepositoryBootable, Concerns\IsRepositorable;

    /**
     *
     * @param mixed $name
     * @param mixed $arguments
     */
    public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        echo "Calling object method '$name' ".implode(', ', $arguments)."\n";
    }
}
