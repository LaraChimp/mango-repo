<?php

namespace LaraChimp\MangoRepo\Repositories;

use LaraChimp\MangoRepo\Concerns;
use LaraChimp\MangoRepo\Contracts\Repository;

abstract class EloquentRepository implements Repository
{
    use Concerns\IsRepositorable,
        Concerns\IsRepositoryBootable,
        Concerns\IsRepositoryScopable;
}
