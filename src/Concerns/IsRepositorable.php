<?php

namespace LaraChimp\MangoRepo\Concerns;

use Illuminate\Database\Eloquent\Model;

trait IsRepositorable
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
     * Update a Model in the database.
     *
     * @param array                                     $values
     * @param \Illuminate\Database\Eloquent\Model|mixed $idOrModel
     * @param array                                     $options
     *
     * @return bool
     */
    public function update(array $values, $idOrModel, array $options = [])
    {
        // Get the Model instance first.
        $model = ($idOrModel instanceof Model) ? $idOrModel : $this->findOrFail($idOrModel);

        // Update model.
        return $this->response($model->update($values, $options));
    }

    /**
     * Delete a record from the database.
     *
     * @param \Illuminate\Database\Eloquent\Model|mixed $idOrModel
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete($idOrModel)
    {
        // Get the Model instance first.
        $model = ($idOrModel instanceof Model) ? $idOrModel : $this->findOrFail($idOrModel);

        // Delete model.
        return $this->response($model->delete());
    }

    /**
     * Find a Model or Models Using some criteria.
     *
     * @param array $criteria
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findBy($criteria = [], $columns = ['*'])
    {
        // Get Model instance.
        $model = $this->getModel();

        // We have some criteria.
        if (! empty($criteria)) {
            // Loop and add each criteria to model.
            foreach ($criteria as $field => $value) {
                $model = $model->where($field, $value);
            }
        }

        // Return models.
        return $this->response($model->get($columns));
    }

    /**
     * Return response from repository.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function response($value)
    {
        return tap($value, function ($results) {
            $this->resetModel();
        });
    }

    /**
     * Resets the Model on the repository.
     *
     * @return void
     */
    protected function resetModel()
    {
        $this->setModel($this->getEloquentModel());
    }
}
