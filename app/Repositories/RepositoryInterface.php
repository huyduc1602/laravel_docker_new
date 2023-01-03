<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all records
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Find a record by id
     *
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create a new record
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update a record
     *
     * @param       $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    /**
     * Delete a record by id
     *
     * @param $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * Find record by 'where' condition
     *
     * @param array $where
     * @return mixed
     */
    public function findWhere(array $where);

    /**
     * Find a record by id and eloquent: relationships
     *
     * @param       $id
     * @param array $relationShips
     * @param array $where
     * @return mixed
     */
    public function findWith($id, array $relationShips, array $where = []);

    /**
     * Find records and update by conditions
     *
     * @param array $where
     * @param array $attributes
     * @return Int
     */
    public function whereAndUpdate(array $where, array $attributes);
}
