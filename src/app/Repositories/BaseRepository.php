<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface {
    protected $_model;

    public function __construct() {
        $this->setModel();
    };

    abstract public function getModel();

    public function setModel(){
        $this->_model = app()->make($this->getModel());
    }

    public function findOne($id) {
        $result = $this->_model->find($id);
        return $result;
    };

    public function getAll(){
        return $this->_model->getAll();
    };

    public function create(array $attributes){
        return $this->_model->create($attributes);
    };

    public function delete($id){
        $target = $this->_model->find($id);
        if($target){
            $target->delete();
            return true;
        }
        return false;
    };

    public function update($id,array $attributes){
        $target = $this->_model->find($id);
        if($target){
            return $this->_model->update($attributes);
        }
        return false;
    };
}