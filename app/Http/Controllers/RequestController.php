<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repository\Contracts\UserRepository;
use App\Repository\Contracts\ItemRepository;
use Illuminate\Http\Request;

class RequestController extends Controller
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
        return view('user.home');
    }

    public function makeItem(Request $request, $id) {
        $user = $this->userRepo->updateUser(auth()->id(), $request->all());
        $viewData = [
          'user' => $user
        ];
        return view('user.profile', $viewData);
    }
}
