<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\MyAuthenticatesUsers;
use App\Repository\Contracts\UserRepository;
use App\Traits\ActivationTrait;
use App\Traits\CaptchaTrait;
use App\Traits\CaptureIpTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;

class AuthController extends Controller {

	use ActivationTrait;
	use CaptchaTrait;
	use MyAuthenticatesUsers;

	private $userRepo;

	public function __construct(UserRepository $userRepo) {
		$this->userRepo = $userRepo;
	}

	protected function create(array $data) {
		$ipAddress = new CaptureIpTrait;
		$data['signup_ip_address'] = $ipAddress->getClientIp();
		$data['verified'] = !config('settings.verification');
		$data['token'] = str_random(64);
		$role = Role::where('slug', '=', 'unverified')->first();
		return $this->userRepo->insertUser($data, $role);
		$this->initiateEmailActivation($user);
		return $user;
	}

	public function register(Request $request) {
		$validator = Validator::make($request->all(),
			[
				'username' => 'required|string|max:255|unique:users|regex:/^[a-zA-Z0-9_.\-]+$/',
				'email' => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:6',
				'sex' => 'required|in:male,female',
			],
			[
				'username.regex' => trans('auth.userNameRegex'),
				'username.unique' => trans('auth.userNameTaken'),
				'username.required' => trans('auth.userNameRequired'),
				'name.required' => trans('auth.nameRequired'),
				'email.required' => trans('auth.emailRequired'),
				'email.email' => trans('auth.emailInvalid'),
				'password.required' => trans('auth.passwordRequired'),
				'password.min' => trans('auth.PasswordMin'),
			]
		);
		if ($validator->fails()) {
			return response()->json([
				'error' => [
					'message' => $validator->messages(),
					'status_code' => 422,
				],
			], 422);
		}
		$user = $this->create($request->all());
		Auth::login($user);
		return $this->registered($request, $user) ?: redirect($this->redirectPath());
	}

	protected function registered(Request $request, $user) {
		$user->generateToken();
		return response()->json(['data' => $user->toArray()], 201);
	}

	public function login(Request $request) {
		$this->validateLogin($request);

		if ($this->attemptLogin($request)) {
			$user = $this->guard()->user();
			$user->generateToken();

			return response()->json([
				'data' => $user->toArray(),
			]);
		}

		return response()->json([
			'error' => [
				'message' => 'Login error, username or password incorrect',
				'status_code' => 422,
			],
		], 422);
	}

	public function socialLogin(Request $request) {
		//$this->validateLogin($request);
		$user = $this->userRepo->getUserByEmail($request->input('email'));
		if (!$user) {
			$ipAddress = new CaptureIpTrait;
			$role = Role::where('slug', '=', 'user')->first();

			$data = [
				'email' => $request->input('email'),
				'name' => $request->input('name'),
				'username' => $request->input('username'),
				'password' => bcrypt(str_random(40)),
				'token' => str_random(64),
				'verified' => true,
				'signup_sm_ip_address' => $ipAddress->getClientIp(),
			];

			$user = $this->userRepo->insertUser($data, $role);

			$account = new SocialAccount([
				'provider_user_id' => $request->input('id'),
				'provider' => $request->input('provider'),
			]);

			$account->user()->associate($user);
			$account->save();
		}

		if ($user) {
			Auth::login($user);
			$user->generateToken();
			return response()->json(['data' => $user->toArray()]);
		}

		return response()->json([
			'error' => [
				'message' => 'Login error',
				'status_code' => 422,
			],
		], 422);
	}

	public function logout(Request $request) {
		$user = Auth::guard('api')->user();

		if ($user) {
			$user->api_token = null;
			$user->save();
		}

		return response()->json(['data' => 'User logged out.'], 200);
	}
}
