<?php

namespace App\Traits;

use App\Repository\VerificationRepository;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

trait ActivationTrait
{

    public function initiateEmailActivation(User $user)
    {

        if ( !config('settings.verification')  || !$this->validateEmail($user)) {

            return true;

        }

        $activationRepostory = new VerificationRepository();
        $activationRepostory->createTokenAndSendEmail($user);

    }

    protected function validateEmail(User $user)
    {

        $validator = Validator::make(['email' => $user->email], ['email' => 'required|email']);

        if ($validator->fails()) {
            return false;
        }

        return true;

    }

}