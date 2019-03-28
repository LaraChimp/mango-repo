<?php

namespace LaraChimp\MangoRepo\Contracts;

interface RepositoryInterface
{
    /**
     * Update a Model in the database.
     *
     * @param array                                     $values
     * @param \Illuminate\Database\Eloquent\Model|mixed $idOrModel
     * @param array                                     $options
     *
     * @return bool
     */
    public function update(array $values, $idOrModel, array $options = []);

    /**
     * Delete a record from the database.
     *
     * @param \Illuminate\Database\Eloquent\Model|mixed $idOrModel
     *
     * @return mixed
     */
    public function delete($idOrModel);

    /**
     * Find a Model or Models Using some criteria.
     *
     * @param array $criteria
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findBy($criteria = [], $columns = ['*']);
}
