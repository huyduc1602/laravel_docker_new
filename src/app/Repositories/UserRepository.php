<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function getModel(): string
    {
        return User::class;
    }

    public function findByEmail($email)
    {
        return $this->_model->where('email', $email)->first();
    }
}
