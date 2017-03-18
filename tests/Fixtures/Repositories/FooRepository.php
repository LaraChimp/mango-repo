<?php

namespace LaraChimp\MangoRepo\Tests\Fixtures\Repositories;

use LaraChimp\MangoRepo\Repositories\EloquentRepository;

class FooRepository extends EloquentRepository
{
    /**
     * The target Eloquent Model.
     */
    const TARGET = \LaraChimp\MangoRepo\Tests\Fixtures\Models\Foo::class;
}
