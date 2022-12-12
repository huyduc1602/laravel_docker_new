<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\UserServiceInterface;

class UserServiceImp implements UserServiceInterface {

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function findOne($id) {
        $user = $this->userRepository->findOne($id);
        return $user;
    }

    public function getAll() {
        $users = $this->userRepository->findAll();
        return $users;
    }

    public function create($data) {
        $user = $this->userRepository->create($data);
        return $user;
    }

    public function delete($id) {
        $user = $this->userRepository->delete($id);
    }

    public function update($id, $data) {
        $user = $this->userRepository->update($id, $data);
        return $user;
    }

    public function checkUserByEmailPassword($email, $password) {
        $user = $this->userRepository->findByEmail($email);
        if($user->password != $password)
            return false;
        return $user;
    }
}
