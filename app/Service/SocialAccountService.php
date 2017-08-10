<?php

namespace App\Service;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Traits\ActivationTrait;
use App\Traits\CaptureIpTrait;

class SocialAccountService
{
    public function createOrGetUser(Provider $provider)
    {
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

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'username' => $providerUser->getUsername(),
                    'password' => bcrypt(str_random(40)),
                    'token' => str_random(64),
                    'verified' => true,
                    'signup_sm_ip_address' => $ipAddress->getClientIp(),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }
}