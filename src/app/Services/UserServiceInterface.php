<?php

namespace App\Services;

interface UserServiceInterface
{
    public function checkUserByUsernamePassword($username, $password);
}
