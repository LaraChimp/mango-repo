<?php

namespace LaraChimp\MangoRepo\Repositories;

use LaraChimp\MangoRepo\Contracts\Repository;
use LaraChimp\MangoRepo\Traits\Repositorable;
use LaraChimp\MangoRepo\Traits\RepositoryBootable;

abstract class EloquentRepository implements Repository
{
    use Repositorable, RepositoryBootable;
}
