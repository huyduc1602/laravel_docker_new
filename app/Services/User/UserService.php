<?php

namespace App\Services\User;

use App\Common\BioStarConstant;
use App\Common\CodeMaster;
use App\Repositories\IndividualUser\IndividualUserRepository;
use App\Repositories\User\UserRepository;
use App\Services\BioStarService;
use App\Repositories\Booking\BookingRepository;
use App\Repositories\IndividualUserPayment\IndividualUserPaymentRepository;
use App\Services\Veritrans\Card\VeritransCardService;

class UserService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        private UserRepository                  $userRepository
    )
    {
    }

    /**
     * Get single system user
     *
     * @return mixed
     */
    public function edit(): mixed
    {
        $user = auth(getApiGuard())->user();
        return $this->userRepository->find($user->id);
    }

}
