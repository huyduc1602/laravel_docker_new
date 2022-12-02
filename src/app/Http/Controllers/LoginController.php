<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show login page
     */
    public function show() {
        if (Auth::check()) return redirect()->to('/welcome');
        
        return view('auth.login');
    }

    public function login(Request $request)
    {   
        // Validation
        // if(!Auth::validate($credentials)):
        //     return redirect()->to('/login')
        //         ->withErrors(['login_failed'=>trans('auth.failed')]);
        // endif;

        //Login successful
        return $this->authenticated();
    }

    protected function authenticated(){
        return redirect()->to('/welcome');
    }
}
