<?php

namespace App\Repositories;

use LaraChimp\MangoRepo\Repositories\EloquentRepository;

class FooRepository extends EloquentRepository
{
    /**
     * The target Eloquent Model.
     */
    const TARGET = \App\Models\Foo::class;
}
