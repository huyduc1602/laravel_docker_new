<?php

namespace App\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;

abstract class BaseRepository implements RepositoryInterface
{
    protected $_model;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    /**
     * @throws BindingResolutionException
     */
    public function setModel()
    {
        $this->_model = app()->make($this->getModel());
    }

    public function findOne($id)
    {
        return $this->_model->find($id);
    }

    public function getAll()
    {
        return $this->_model->getAll();
    }

    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }

    public function delete($id): bool
    {
        $target = $this->_model->find($id);
        if ($target) {
            $target->delete();
            return true;
        }
        return false;
    }

    public function update($id, array $attributes): bool
    {
        $target = $this->_model->find($id);
        if ($target) {
            return $this->_model->update($attributes);
        }
        return false;
    }
}
