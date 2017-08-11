<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ActivationTrait;
use App\Traits\CaptchaTrait;
use App\Traits\CaptureIpTrait;
use App\Repository\Contracts\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use ActivationTrait;
    use CaptchaTrait;
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    private $userRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['captcha'] = $this->captchaCheck();

        if (!config('settings.reCaptchStatus')) {
            $data['captcha'] = true;
        }

        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users|regex:/[^a-zA-Z0-9_.\-]$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'sex' => 'required|in:male,female',
            'g-recaptcha-response' => '',
            'captcha' => 'required|min:1'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data){
        $ipAddress = new CaptureIpTrait;
        $data['signup_ip_address'] = $ipAddress->getClientIp();
        $data['verified'] = !config('settings.verification');
        $data['token'] = str_random(64);
        $role = Role::where('slug', '=', 'unverified')->first();
        return $this->userRepo->insertUser($data, $role);
        $this->initiateEmailActivation($user);
        return $user;
    }
}
