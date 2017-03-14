<?php

namespace LaraChimp\MangoRepo\Repositories;

use LaraChimp\MangoRepo\Contracts\Repository;

abstract class EloquentRepository implements Repository
{
    /**
     * {@inheritdoc}
     */
    public function all($columns = ['*'])
    {
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $attributes = [])
    {
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $values, $idOrModel)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function delete($idOrModel)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function find($id, $columns = ['*'])
    {
    }

    /**
     * {@inheritdoc}
     */
    public function findBy($criteria = [], $columns = ['*'])
    {
    }
}
