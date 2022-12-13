<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository {
    public function getModel(){
        return User::class;
    }

    public function getByEmail($email){
        return $this->_model->where('email',$email)->first();
    }
}