<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repository\Contracts\DesignerRepository;
use App\Repository\Contracts\UserRepository;
use App\Repository\Contracts\ItemRepository;
use Illuminate\Http\Request;

class DesignerController extends Controller
{
    public $userRepo;
    public $designerRepo;
    public $itemRepo;

    public function __construct(UserRepository $userRepo, DesignerRepository $designerRepo, ItemRepository $itemRepo) //inject repositories
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->itemRepo = $itemRepo;
        $this->designerRepo = $designerRepo;
    }

    public function index(){
        return view('user.home');
    }

    public function getSuggestion(Request $request) {
        $this->validate($request, [
            'keyword' => 'required',
        ]);
        $arr = $this->designerRepo->searchName($request->input('keyword'));
        $value = '<ul id="designer-list">';
        foreach($arr as $ar) {
            $value .= '<li onClick="selectDesigner(\''. $ar .'\');">' . $ar . '</li>';
        }
        $value .= '</ul>';
        return response()->json(['response' => true, 'value' => $value]);
    }
}
