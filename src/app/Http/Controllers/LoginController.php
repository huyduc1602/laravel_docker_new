<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\NewsServiceImp;
use App\Services\UserServiceImp;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected NewsServiceImp $newsService;

    protected UserServiceImp $userService;

    public function __construct(NewsServiceImp $newsService, UserServiceImp $userService)
    {
        $this->newsService = $newsService;
        $this->userService = $userService;
    }

    /**
     * Show login page
     */
    public function show()
    {
        if (Auth::check()) {
            return redirect()->to('/welcome');
        }
        $news = $this->newsService->getNewsOf30Days();
    
        return view('login', compact('news'));
    }

    public function login(LoginRequest $request)
    {
        //Login processing
        $user = $this->userService->checkUserByEmailPassword($request->id, $request->password);

        //Login successful
        if ($user) {
            return $this->authenticated();
        }
        return back()->withInput($request->all())->withErrors(['login_failed' => trans('auth.failed')]);
    }

    protected function authenticated()
    {
        return redirect()->to('/welcome');
    }
}
