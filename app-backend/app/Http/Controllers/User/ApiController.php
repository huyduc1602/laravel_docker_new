<?php

use App\Services\User\UserService;

class ApiController extends \App\Http\Controllers\Controller
{
    /**
     * ApiController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(
        private UserService           $userService,
    )
    {
    }

}
