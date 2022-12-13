<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserServiceImp implements UserServiceInterface
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findOne($id)
    {
        return $this->userRepository->findOne($id);
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function create($data)
    {
        return $this->userRepository->create($data);
    }

    public function delete($id)
    {
        $user = $this->userRepository->delete($id);
    }

    public function update($id, $data): bool
    {
        return $this->userRepository->update($id, $data);
    }

    public function checkUserByEmailPassword($email, $password): bool
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user->password != $password) {
            return false;
        }
        return $user;
    }
}
