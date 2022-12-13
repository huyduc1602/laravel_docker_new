<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\NewsServiceImp;
use App\Services\UserServiceImp;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $newsService;

    protected $userService;

    public function __construct(NewsServiceImp $newsService,UserServiceImp $userService){
        $this->newsService = $newsService;
        $this->userService = $userService;
    }

    /**
     * Show login page
     */
    public function show() {
        if (Auth::check()) return redirect()->to('/welcome');
        $news = $this->newsService->getNewsOf30Days();
        return view('auth.login', compact('news'));
    }

    public function login(LoginRequest $request)
    {   
        //Validation
        $id = $request->id;
        $password = $request->password;

        //Login processing
        $user = $this->userService->checkUserByEmailPassword($id, $password);
        
        //Login successful
        if($user)
            return $this->authenticated();
        return back()->withError(['login_failed'=>trans('auth.failed')]);
    }

    protected function authenticated(){
        return redirect()->to('/welcome');
    }
}
