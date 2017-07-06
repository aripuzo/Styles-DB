<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repository\Contracts\UserRepository;
use App\Repository\Contracts\ItemRepository;
use Illuminate\Http\Request;


class ItemController extends Controller{
    //
    public $userRepo;
    public $itemRepo;

    public function __construct(UserRepository $userRepo, ItemRepository $itemRepo){
        $this->userRepo = $userRepo;
        $this->itemRepo = $itemRepo;
    }

    public function index()
    {
        return view('home');
    }

    public function createItem(Request $request) { // example of how to use repo
    	$this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'image1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image3' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image4' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if(isset(Auth::user()->store)){
        	$images = array();
        	$store = Auth::user()->store;
        	if ($request->hasFile('image1'))
    			$images[0] = $this->saveImage('image1', $store->id, $request);
    		if ($request->hasFile('image2'))
    			$images[1] = $this->saveImage('image2', $store->id, $request);
    		if ($request->hasFile('image3'))
    			$images[2] = $this->saveImage('image3', $store->id, $request);
    		if ($request->hasFile('image4'))
    			$images[3] = $this->saveImage('image4', $store->id, $request);
        	$data = $request->all();
        	$data['images'] = $images;
        	$this->productRepo->createProduct($store->id, $data);
        	return redirect('/dashboard/mystore/additem')->with('message', 'Your product has been added successfully');
        }
        return redirect('/dashboard/mystore/additem')->with('message', 'Store not found for user, please create a store first');
    }

    private function saveImage($name, $id, $request){
    	$image = $request->file($name);
    	$imageName = md5(microtime()).'_'.$id.'.'.$image->getClientOriginalExtension();
        $image->move(public_path('product/images'), $imageName);
        return $imageName;
    }

    public function favItem(Request $request) { // example of how to use repo
    	$this->validate($request, [
            'id' => 'required|max:255',
        ]);
        $value = $this->itemRepo->favItem(auth()->id(), $request->input('id'));
        if($value)
        	return response()->json(['response' => true]);
        else
        	return response()->json(['response' => false, 'message' => 'Error occured']);
    }

    public function bookmarkItem(Request $request) { // example of how to use repo
    	$this->validate($request, [
            'id' => 'required|max:255',
        ]);
        $value = $this->itemRepo->bookmarkItem(auth()->id(), $request->input('id'));
        if($value)
        	return response()->json(['response' => true]);
        else
        	return response()->json(['response' => false, 'message' => 'Error occured']);
    }

    public function downloadItem(Request $request) { // example of how to use repo
    	$this->validate($request, [
            'id' => 'required|max:255',
        ]);
        $pathToFile = $this->itemRepo->downloadItem(auth()->id(), $request->input('id'));
        if(isset($value))
        	return response()->download($pathToFile, $this->itemRepo->name . '.jpg');
        else
        	return response()->json(['response' => false, 'message' => 'Error occured']);
    }

    public function getItems(Request $request, $category = null, $style = null, $fabric = null, $color = null){
    	$filters = array();
    	$order = array();
    	$page = 1;
    	$limit = 15;
    	if(isset($category))
    		$filters['category'] = $category;
    	if(isset($style))
    		$filters['stlye'] = $style;
    	if(isset($fabric))
    		$filters['fabric'] = $fabric;
    	if(isset($color))
    		$filters['color'] = $color;
    	if($request->has('order_by'))
    		$order['orderBy'] = $request->input('order_by');
    	if($request->has('order_by'))
    		$order['orderDir'] = $request->input('order_dir');
    	if($request->has('limit'))
    		$limit = $request->input('limit');
    	if($request->has('page'))
    		$limit = $request->input('page');
    	$items = $this->itemRepo->getItems($filters, $page, $order, $limit);
        $viewData = [
          'items' => $items
        ];
        return view('portfolio', $viewData);
    }

    public function searchItems(Request $request){
    	$order = array();
    	$page = 1;
    	$limit = 15;
    	if($request->has('order_by'))
    		$order['orderBy'] = $request->input('order_by');
    	if($request->has('order_by'))
    		$order['orderDir'] = $request->input('order_dir');
    	if($request->has('limit'))
    		$limit = $request->input('limit');
    	if($request->has('page'))
    		$limit = $request->input('page');
    	$items = $this->itemRepo->searchItems($request->input('q'), $page, $order, $limit);
        $viewData = [
          'items' => $items
        ];
        return view('portfolio', $viewData);
    }
}
