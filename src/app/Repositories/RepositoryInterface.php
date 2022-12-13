<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function findOne($id);

    public function getAll();

    public function create(array $attributes);

    public function delete($id);

    public function update($id, array $attributes);
}
