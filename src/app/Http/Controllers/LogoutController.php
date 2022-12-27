<?php

namespace App\Http\Controllers;

use App\Services\NewsServiceImp;
use App\Services\UserServiceImp;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    protected UserServiceImp $userService;

    public function __construct(UserServiceImp $userService)
    {
        $this->userService = $userService;
    }

    public function logOut()
    {
        //Logout processing
        Auth::logout();
        return redirect()->to('/login');
    }
}
