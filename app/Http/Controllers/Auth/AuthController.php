<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Socialite;

class AuthController extends Controller {
    
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider) {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        //return redirect($this->redirectTo);
        return redirect()->home();
    }

    public function findOrCreateUser($user, $provider) {

        $authUser = User::where('email', $user->email)->first();

        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'photo'   => $user->getAvatar(),
            'provider_id' => $user->id
        ]);
    }

}
