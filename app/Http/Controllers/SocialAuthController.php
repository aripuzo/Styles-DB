<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

class SocialAuthController extends Controller{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function callback(SocialAccountService $service, $provider){
        $user = $service->createOrGetUser(Socialite::driver($provider));//->user());
        auth()->login($user);
        return redirect()->route('/');
    }
}
