<?php

namespace LaraChimp\MangoRepo\Repositories;

use LaraChimp\MangoRepo\Concerns;
use LaraChimp\MangoRepo\Contracts\RepositoryInterface as RepositoryContract;

abstract class EloquentRepository implements RepositoryContract
{
    use Concerns\IsRepositorable,
        Concerns\IsRepositoryBootable,
        Concerns\IsRepositoryScopable;
}
