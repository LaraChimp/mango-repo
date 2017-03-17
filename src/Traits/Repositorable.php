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
     * Get all of the models from the database.
     *
     * @param array|mixed $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public function all($columns = ['*'])
    {
        return $this->getModel()->all($columns);
    }

    /**
     * Paginate the given query.
     *
     * @param  int      $perPage
     * @param  array    $columns
     * @param  string   $pageName
     * @param  int|null $page
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param  int      $perPage
     * @param  array    $columns
     * @param  string   $pageName
     * @param  int|null $page
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes = [])
    {
    }

    /**
     * Update a Model in the database.
     *
     * @param array                                     $values
     * @param \Illuminate\Database\Eloquent\Model|mixed $idOrModel
     *
     * @return int
     */
    public function update(array $values, $idOrModel)
    {
    }

    /**
     * Delete a record from the database.
     *
     * @param \Illuminate\Database\Eloquent\Model|mixed $idOrModel
     *
     * @return mixed
     */
    public function delete($idOrModel)
    {
    }

    /**
     * Find a Model in the Database using the ID.
     *
     * @param mixed $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find($id, $columns = ['*'])
    {
    }

    /**
     * Find a Model or Models Using some criteria.
     *
     * @param array $criteria
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($criteria = [], $columns = ['*'])
    {
    }
}
