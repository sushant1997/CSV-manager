<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function show_login_form()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'message' => 'Invalid Email or password.',
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
