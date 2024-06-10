<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller

{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();
            if (!$user) {
                $new_user = User::create(
                    [
                        'google_id' => $google_user->getId(),
                        'name' => $google_user->getName(),
                        'email' => $google_user->getEmail()
                    ]
                );

                Auth::login($new_user);
                return redirect()->intended('dashboard');
            } else {
                Auth::login($user);

                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $th) {

            return redirect()->route('login')->withErrors(['message' => 'something went wrong, please try again later!']);
        }
    }
}
