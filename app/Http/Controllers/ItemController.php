<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repository\Contracts\UserRepository;
use App\Repository\Contracts\ItemRepository;
use App\Repository\Contracts\ItemPropertyRepository;
use Illuminate\Http\Request;


class ItemController extends Controller{
    //
    public $userRepo;
    public $itemRepo;
    public $itemPropertyRepo;

    public function __construct(UserRepository $userRepo, ItemRepository $itemRepo, ItemPropertyRepository $itemPropertyRepo){
        $this->userRepo = $userRepo;
        $this->itemRepo = $itemRepo;
        $this->itemPropertyRepo = $itemPropertyRepo;
    }

    public function createItem(Request $request) { // example of how to use repo
    	$this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required',
            'categories' => 'required',
            'styles' => 'required',
            'fabrics' => 'required',
            'colors' => 'required',
        ]);
        $item = $this->itemRepo->addItem($request->all());
        $viewData = [
          'item' => $item,
          'title' => 'New',
        ];
        return view('portfolio', $viewData);
    }

    private function saveImage($name, $id, $request){
    	$image = $request->file($name);
    	$imageName = md5(microtime()).'_'.$id.'.'.$image->getClientOriginalExtension();
        $image->move(public_path('product/pic/images'), $imageName);
        return $imageName;
    }

    public function favItem(Request $request) { // example of how to use repo
    	$this->validate($request, [
            'id' => 'required|numeric|exists:items',
        ]);
        //$value = $this->itemRepo->favItem(auth()->id(), $request->input('id')) . '<i class="fa fa-heart-o"></i>';
        $value = '10 <i class="fa fa-heart-o"></i>';
        if($value)
        	return response()->json(['response' => true, 'value' => $value]);
        else
        	return response()->json(['response' => false, 'message' => 'Error occured']);
    }

    public function bookmarkItem(Request $request) { // example of how to use repo
    	$this->validate($request, [
            'id' => 'required|max:255',
        ]);
        $value = $this->itemRepo->bookmarkItem(auth()->id(), $request->input('id'));
        if($value)
        	return response()->json(['response' => true, 'value' => $value]);
        else
        	return response()->json(['response' => false, 'message' => 'Error occured']);
    }

    public function downloadItem($id) { // example of how to use repo
    	// $this->validate($request, [
     //        'id' => 'required|max:255',
     //    ]);
        $pathToFile = $this->itemRepo->downloadItem(auth()->id(), $id);
        if(isset($value))
        	return response()->download($pathToFile, $this->itemRepo->name . '.jpg');
        else
        	return response()->json(['response' => false, 'message' => 'Error occured']);
    }

    public function getItem($id){
    	$item = $this->itemRepo->getItem($id);
    	if(isset($item)){
	    	$viewData = [
	          'item' => $item,
	          'title' => $item->getSEOTitle(),
	          'description' => $item->getSEODescription(),
	        ];
	    	return view('item.single', $viewData);
	    }

    }

    public function getItemsByCategory(Request $request, $category = null){
    	$items = $this->getItems($request, $category, null, null, null);
    	if(isset($category)){
    		$category = $this->itemPropertyRepo->getCategoryBySlug($category);
    		$title = $category->name;
    		$selected = $category->id;
    	}
    	else{
    		$title = 'Catalogue';
    		$selected = 0;
    	}
        $viewData = [
          'items' => $items,
          'title' => $title,
          'description' => $title,
          'selected' => $selected,
        ];
        return view('portfolio', $viewData);
        //var_dump($items->first()->downloads->count());
    }

    private function getItems(Request $request, $category = null, $style = null, $fabric = null, $color = null){
    	$filters = array();
    	$order = array();
    	$page = 1;
    	$limit = 15;
    	if(isset($category))
    		$filters['category'] = $category;
    	if(isset($style))
    		$filters['style'] = $style;
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
    	return $this->itemRepo->getItems($filters, $page, $order, $limit);
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
          'items' => $items,
          'title' => 'Search \''. $request->input('q') .'\'',
          'description' => '',
        ];
        return view('portfolio', $viewData);
    }

    private function popularItems(Request $request){
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
    	if($request->has('limit'))
    		$limit = $request->input('limit');
    	if($request->has('page'))
    		$limit = $request->input('page');
    	return $this->itemRepo->getPopularItems($filters, $page, $limit);
    }
}
