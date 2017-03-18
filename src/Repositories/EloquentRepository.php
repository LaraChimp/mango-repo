<?php

namespace LaraChimp\MangoRepo\Repositories;

use LaraChimp\MangoRepo\Concerns;
use LaraChimp\MangoRepo\Contracts\Repository;

abstract class EloquentRepository implements Repository
{
    use Concerns\IsRepositoryBootable, Concerns\IsRepositorable;
}
