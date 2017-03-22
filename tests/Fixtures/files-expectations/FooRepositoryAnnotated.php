<?php

namespace App\Repositories;

use LaraChimp\MangoRepo\Annotations\EloquentModel;
use LaraChimp\MangoRepo\Repositories\EloquentRepository;

/**
 * @EloquentModel(target="App\Models\Foo")
 */
class FooRepositoryAnnotated extends EloquentRepository
{
    //
}
