<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repository\Contracts\UserRepository;
use App\Repository\Contracts\ItemCreditRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $userRepo;
    public $itemRepo;

    public function __construct(UserRepository $userRepo, ItemRepository $itemRepo) //inject repositories
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->itemRepo = $itemRepo;
    }

    public function index(){
        return view('home');
    }

    public function updateUser(Request $request) {
        $user = $this->userRepo->updateUser(auth()->id(), $request->all());
        $viewData = [
          'user' => $user
        ];
        return view('user.profile', $viewData);
    }

    public function showProfile() {
        $user = $this->userRepo->getUser(auth()->id());
        $viewData = [
          'user' => $user
        ];
        return view('user.profile', $viewData);
    }
}
