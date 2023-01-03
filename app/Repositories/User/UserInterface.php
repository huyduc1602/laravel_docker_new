<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserInterface
{
    public function createUser(array $request): User;
    public function updateUser(array $request, $id): bool;
}
