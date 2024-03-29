<?php

namespace App\Repository;

use App\Models\Verification;
use App\Models\User;
use App\Notifications\SendWelcomeEmail;
use App\Traits\CaptureIpTrait;
use Carbon\Carbon;

class VerificationRepository
{

    public function createTokenAndSendEmail(User $user)
    {

        $activations = Verification::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subHours(config('settings.timePeriod')))
            ->count();

        if ($activations >= config('settings.maxAttempts')) {
            return true;
        }

        //if user changed activated email to new one
        if ($user->verified) {

            $user->update([
                'verified' => false
            ]);

        }

        // Create new Activation record for this user
        $activation = self::createNewActivationToken($user);

        // Send activation email notification
        self::sendNewActivationEmail($user, $activation->token);

    }

    public function createNewActivationToken(User $user) {

        $ipAddress              = new CaptureIpTrait;
        $activation             = new Verification;
        $activation->user_id    = $user->id;
        $activation->token      = str_random(64);
        $activation->ip_address = $ipAddress->getClientIp();
        $activation->save();

        return $activation;

    }

    public function sendNewActivationEmail(User $user, $token) {

        $user->notify(new SendWelcomeEmail($token));

    }

    public function deleteExpiredActivations()
    {

        Verification::where('created_at', '<=', Carbon::now()->subHours(72))->delete();

    }
}