<?php

namespace App\Repositories\User;

use Illuminate\Contracts\Pagination\Paginator;

interface UserInterface
{
    /**
     * Search system user
     *
     * @param array $request
     * @return Paginator
     */
    public function searchSystemUser(array $request): Paginator;

    /**
     * Create a new user system admin
     *
     * @param array $request
     * @return bool
     */
    public function createSystemAdmin(array $request): bool;

    /**
     * Create a user
     *
     * @param array $request
     * @param $id
     * @return bool
     */
    public function createUser(array $request): mixed;

    /**
     * Update a user
     *
     * @param array $request
     * @param $id
     * @return bool
     */
    public function updateUser(array $request, $id): bool;
}
