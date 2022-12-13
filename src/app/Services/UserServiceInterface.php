<?php

namespace App\Services;

interface UserServiceInterface
{
    public function checkUserByEmailPassword($email, $password);
}
