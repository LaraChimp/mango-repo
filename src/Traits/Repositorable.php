<?php

namespace LaraChimp\MangoRepo\Traits;

use Illuminate\Database\Eloquent\Model;

trait Repositorable
{
    /**
     * The Eloquent Model.
     *
     * @var Model
     */
    protected $model;

    /**
     * Sets the Model to the Repo.
     *
     * @param Model $model
     *
     * @return self
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Gets the Eloquent Model instance.
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

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
