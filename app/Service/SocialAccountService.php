<?php

namespace App\Service;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Repository\UserRepo;
use App\Traits\ActivationTrait;
use App\Traits\CaptureIpTrait;

class SocialAccountService{

    private $userRepo;

    public function __construct(UserRepository $userRepo){
        $this->userRepo = new UserRepo;
    }

    public function createOrGetUser(Provider $provider){
        $providerUser = $provider->user();
        $providerName = class_basename($provider); 
        $account = SocialAccount::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $ipAddress  = new CaptureIpTrait;
                $role       = Role::where('slug', '=', 'user')->first();

                $data = [
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'username' => $providerUser->getUsername(),
                    'password' => bcrypt(str_random(40)),
                    'token' => str_random(64),
                    'verified' => true,
                    'signup_sm_ip_address' => $ipAddress->getClientIp(),
                ];

                $user $this->userRepo->insertUser($data, $role);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }
}