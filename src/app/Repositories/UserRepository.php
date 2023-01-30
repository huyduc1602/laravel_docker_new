<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function getModel(): string
    {
        return User::class;
    }

    public function findByUsername($username)
    {
        return $this->_model->where('user_name', $username)->first();
    }
}
