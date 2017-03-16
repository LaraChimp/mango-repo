<?php

namespace LaraChimp\MangoRepo\Tests\Fixtures\Repositories;

use LaraChimp\MangoRepo\Annotations\EloquentModel;
use LaraChimp\MangoRepo\Repositories\EloquentRepository;

/**
 * @EloquentModel(target="LaraChimp\MangoRepo\Tests\Fixtures\Models\User")
 */
class UserRepository extends EloquentRepository
{
    //
}
