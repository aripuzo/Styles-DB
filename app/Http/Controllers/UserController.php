<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repository\Contracts\UserRepository;
use App\Repository\Contracts\ItemRepository;
use Illuminate\Http\Request;
use SEO;

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
        return view('user.home');
    }

    public function updateUser(Request $request) {
        if($request->input('password') != null){
            $this->validate($request, [
                'old_password' => 'required|string|min:6',
                'password' => 'required|string|min:6|confirmed'
            ]);
            $this->userRepo->updatePassword(auth()->id(), $request->input('password'));
        }
        $user = $this->userRepo->updateUser(auth()->id(), $request->all());
        $viewData = [
          'user' => $user,
          'title' => $user->getTitle(),
        ];
        return view('user.profile', $viewData);
    }

    public function showProfile() {
        $user = $this->userRepo->getUser(auth()->id());
        $viewData = [
          'user' => $user,
          'title' => $user->getTitle(),
        ];
        return view('user.profile', $viewData);
        //return $this->userRepo->getRecommendedTest(auth()->id(), 15);
    }

    public function getBookmarks() {
        $user = $this->userRepo->getUser(auth()->id());
        $items = array();
        foreach($user->bookmarks as $bookmark){
        	$items[] = $bookmark->item;
        }
	    $viewData = [
	        'items' => $items,
	        'title' => $user->getTitle(),
	    ];
        return view('user.bookmarks', $viewData);
    }
}
