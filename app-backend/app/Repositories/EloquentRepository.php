<?php

namespace App\Repositories;

use App\Common\CommonFunction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var
     */
    protected $_model;

    /**
     * Initial constructor
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Get model
     *
     * @return string
     */
    abstract public function getModel(): string;

    /**
     * Set model
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setModel()
    {
        $this->_model = app()->make($this->getModel());
    }

    /**
     * Get all records
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this->_model->all();
    }

    /**
     * Find a record by id
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->_model->find($id);
    }

    /**
     * Create a new record
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }

    /**
     * Update a record
     *
     * @param       $id
     * @param array $attributes
     * @return false|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if (empty($result)) {
            return false;
        }

        $result->update($attributes);

        return $result;
    }

    /**
     * Delete a record by id
     *
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $result = $this->find($id);
        if (empty($result)) {
            return false;
        }

        $result->delete();

        return true;
    }

    /**
     * Find record by 'where' condition
     *
     * @param array $where
     * @return mixed
     */
    public function findWhere(array $where)
    {
        return $this->_model->where($where)->first();
    }

    /**
     * Find a record by id and eloquent: relationships
     *
     * @param       $id
     * @param array $relationShips
     * @param array $where
     * @return mixed
     */
    public function findWith($id, array $relationShips, array $where = [])
    {
        return $this->_model
            ->with($relationShips)
            ->when(!empty($where), function ($query) use ($where) {
                return $query->where($where);
            })
            ->find($id);
    }

    /**
     * update an existing record in the database or create it if no matching record exists
     *
     * @param array $condition
     * @param array $record
     * @return mixed
     */
    public function updateOrCreate(array $condition, array $record): mixed
    {
        return $this->_model->updateOrCreate($condition, $record);
    }

    /**
     * Find records and update by conditions
     *
     * @param array $where
     * @param array $attributes
     * @return Int the number of records has been updated
     */
    public function whereAndUpdate(array $where, array $attributes): int
    {
        return $this->_model->where($where)->whereNull('deleted_at')->update($attributes);
    }

    /**
     * Find record by 'where' condition
     *
     * @param array $where
     * @return mixed
     */
    public function findWhereAll(array $where): mixed
    {
        return $this->_model->where($where)->get();
    }
}
