<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repository\Contracts\UserRepository;
use App\Repository\Contracts\ItemRepository;
use App\Repository\Contracts\ItemPropertyRepository;
use App\Repository\Contracts\StatRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Excel;
use SEO;
//!TAMuno__123
//6Sy'eejZH5r4P}{E


class ItemController extends Controller{
    //
    private $userRepo;
    private $itemRepo;
    private $itemPropertyRepo;
    private $statRepo;
    private $limit = 15;
    private $defaultSort = 'latest';
    private $defaultOrder = 'created_at';
    private $popularOrder = 'ratings';//'favorites';

    public function __construct(UserRepository $userRepo, ItemRepository $itemRepo, ItemPropertyRepository $itemPropertyRepo, StatRepository $statRepo){
        $this->userRepo = $userRepo;
        $this->itemRepo = $itemRepo;
        $this->itemPropertyRepo = $itemPropertyRepo;
        $this->statRepo = $statRepo;
    }

    public function index(Request $request){
        Log::info('Index paged called.');
        if (Auth::check()){
            if(!$request->has('sort'))
                $request->merge(['sort' => 'recommended']);
            $title = 'Home';
        }
        else
            $title = 'Latest Styles: Aso ebi, Ankara, Lace, Senator, Agbada';
    	$items = $this->getItems($request, null, null, null, null);
	    if($request->has('sort'))
	    	$order = $request->input('sort');
        else
            $order = $this->defaultSort;
        SEO::setTitle($title);
	    $viewData = [
	        'items' => $items,
	        'order' => $order,
	    ];
    	if (Auth::check()){
			return view('user.home', $viewData);
	    }
    	else{
	    	return view('welcome', $viewData);
	    }
    }

    public function createItem(Request $request) {
    	$this->validate($request, [
            'categories' => 'required',
        ]);
        $item = $this->itemRepo->addItem($request->all());
        $viewData = [
          'item' => $item,
          'title' => 'New',
        ];
        return view('item.new', $viewData);
    }

    public function createItemExcel(Request $request) {
    	$this->validate($request, [
            'file' => 'required',
        ]);
        //try {
        	Excel::load(Input::file('file'), function ($reader) {
            	//http://res.cloudinary.com/oversabi/image/upload/v1501209513/IMG-20170613-WA0000_vvwgrs.jpg
                foreach ($reader->toArray() as $row) {
                    if(isset($row['images'])){
                        $images = array();
                        $image_ids = array();
                        $imgs = explode(',' , $row['images']);
                        foreach ($imgs as $img) {
                            $images[] = 'http://res.cloudinary.com/oversabi/image/upload/v1501209513/'.$img .'.jpg';
                            $image_ids[] = $img;
                        }
                    	$data = array(
                    		'add_categories' => $row['categories'],
                    		'add_styles' => $row['styles'],
                    		'add_fabrics' => $row['fabrics'],
                    		'add_colors' => $row['colors'],
                    		'add_tags' => $row['tags'],
                            'images' => $images,
                            'image_ids' => $image_ids,
                            'designer' => $row['designer'],
                    	);
                    	$this->itemRepo->addItem($data);
                    }
                    //var_dump($data);
                }
                
            });
            return back()->with('message','You have successfully uploaded styles.');
            //\Session::flash('success', 'Users uploaded successfully.');
        // } catch (\Exception $e) {
        //     var_dump($e->getMessage());
        // }
    }

    public function createItemUser(Request $request) {
        $this->validate($request, [
            'categories' => 'required',
            'styles' => 'required',
            'images' => 'required',
            'username' => 'string|max:255|unique:users',
            'email' => 'string|email|max:255|unique:users',
        ]);
        if($request->has('email')){
        	$user = $this->userRepo->insert($request->all());
        	Auth::login($user);
        }
        elseif(Auth::check()){
        	$user = $this->userRepo->getUser(auth()->id());
        }
        else
            return back();
        $request->merge(['user_id' => $user->id]);
        $item = $this->itemRepo->addItem($request->all());
        return back()->with('message','You have successfully upload style.');
    }

    private function uploadFile(Request $request){
        if($request->hasFile('image_file')){  
            \Cloudder::upload($request->file('image_file'));
            $c=\Cloudder::getResult();             
            if($c){
               return $c['url'];
            }
            
        }
        // return back()
        //     ->with('success','You have successfully upload images.')
        //     ->with('image',$c['url']);
        // array:15 [▼
        //   "public_id" => "sample"
        //   "version" => 1499596361
        //   "width" => 864
        //   "height" => 576
        //   "format" => "jpg"
        //   "resource_type" => "image"
        //   "created_at" => "2017-07-09T10:32:41Z"
        //   "tags" => []
        //   "bytes" => 120253
        //   "type" => "upload"
        //   "etag" => "14500e08ec2701bfd36a8e9a5585261e"
        //   "url" => "http://res.cloudinary.com/demo/image/upload/v1499589454/sample.jpg"
        //   "secure_url" => "http://res.cloudinary.com/demo/image/upload/v1499589454/sample.jpg"
        //   "original_filename" => "sample"
        // ]
        // Cloudder::destroyImage($publicId, array $options)
        // Cloudder::delete($publicId, array $options)
    }

    private function saveImage($name, $id, $request){
    	$image = $request->file($name);
    	$imageName = md5(microtime()).'_'.$id.'.'.$image->getClientOriginalExtension();
        $image->move(public_path('ustyles/pic/images'), $imageName);
        return $imageName;
    }

    public function favItem(Request $request) {
    	$this->validate($request, [
            'id' => 'required|numeric|exists:items',
        ]);
        Log::info('User favorite item.', ['user_id' => auth()->id(), 'item_id' => $request->input('id')]);
        $value = $this->itemRepo->favItem(auth()->id(), $request->input('id'));
        if($value){
        	return response()->json(['response' => true, 'value' => $value]);
        }
        else
        	return response()->json(['response' => false, 'message' => 'Error occured']);
    }

    public function bookmarkItem(Request $request) {
    	$this->validate($request, [
            'id' => 'required|numeric|exists:items',
        ]);
        Log::info('User bookmark item.', ['user_id' => auth()->id(), 'item_id' => $request->input('id')]);
        $value = $this->itemRepo->bookmarkItem(auth()->id(), $request->input('id'));
        if($value){
        	return response()->json(['response' => true, 'value' => $value]);
        }
        else
        	return response()->json(['response' => false, 'message' => 'Error occured']);
    }

    public function downloadItem(Request $request) {
    	$this->validate($request, [
            'id' => 'required|numeric|exists:items',
        ]);
        $pathToFile = $this->itemRepo->downloadItem(auth()->id(), $request->input('id'));
        if(isset($pathToFile))
        	return response()->json(['response' => true, 'url' => $pathToFile, 'filename' => $this->itemRepo->getItem($request->input('id'))->name . '.jpg']);
        else
        	return response()->json(['response' => false, 'message' => 'Error occured']);
    }

    public function makeCommentItem(Request $request) {
        $this->validate($request, [
            'id' => 'required|numeric|exists:items',
            'text' => 'required',
        ]);
        $value = $this->itemRepo->commentOnItem(auth()->id(), $request->input('id'), $request->input('text'), $request->input('comment_id'));
        return redirect()->action(
            'ItemController@getItem', ['id' => $request->input('id')]
        );
    }

    private function isValid($str) {
        return !preg_match('/[^A-Za-z0-9._#\\-$]/', $str);
    }

    public function searchSuggestion(Request $request){
        $query = $request->get('query',''); 
        //$query  = 'ank_ara';    
        $posts = $this->statRepo->searchSuggestion($query);
        $value = '<ul id="search-list">';
        foreach($posts as $ar) {
            $value .= '<li onClick="selectSearch(\''. $ar .'\');">' . $ar . '</li>';
        }
        $value .= '</ul>'; 
        return response()->json($posts);
        //return response()->json($this->isValid($query));

    }

    public function makeItem($id){
    	$item = $this->itemRepo->getItem($id);
    	$similar = $this->itemRepo->getSimilarItems($id);
    	if(isset($item)){
	    	$viewData = [
	          'item' => $item,
	          'title' => $item->getSEOTitle(),
	          'description' => $item->getSEODescription(),
	          'related' => $similar,
	        ];
	    	return view('item.make', $viewData);
	    }
    }

    public function getItem($id){
    	$item = $this->itemRepo->getItem($id);
    	$similar = $this->itemRepo->getSimilarItems($id);
    	if(isset($item)){
            SEO::setTitle($item->getSEOTitle());
            SEO::setDescription($item->getSEODescription());
	    	$viewData = [
	          'item' => $item,
	          'related' => $similar,
	        ];
            $this->statRepo->itemViewed($id, auth()->id());
	    	return view('item.single', $viewData);
	    }
        else{
            Log::error('Item not found for item: '.$id);
            abort(404, 'The resource you are looking for could not be found');
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
            Log::error('Category not found for slug: '.$category);
    		$title = 'Catalogue';
    		$selected = 0;
    	}
    	if($request->has('sort'))
    		$order = $request->input('sort');
        else
            $order = $this->defaultSort;
        SEO::setTitle($title);
        $viewData = [
          'items' => $items,
          'selected' => $selected,
          'order' => $order,
        ];
        if(isset($category) && (!$request->has('page') || $request->input('page') == '1'))
            $this->statRepo->categoryViewed($category->id, auth()->id());
        return view('item.portfolio', $viewData);
    }

    public function getItemsByStyle(Request $request, $style = null){
        $items = $this->getItems($request, null, $style, null, null);
        if(isset($style)){
            $style = $this->itemPropertyRepo->getStyleBySlug($style);
            $title = $style->name;
            $selected = $style->id;
        }
        else{
            $title = 'Style: '.$style->name;
            $selected = 0;
        }
        if($request->has('sort'))
            $order = $request->input('sort');
        else
            $order = $this->defaultSort;
        SEO::setTitle($title);
        $viewData = [
          'items' => $items,
          'selected' => $selected,
          'order' => $order,
        ];
        if(isset($style) && (!$request->has('page') || $request->input('page') == '1'))
            $this->statRepo->styleViewed($style->id, auth()->id());
        return view('item.portfolio', $viewData);
    }

    public function getItemsByFabric(Request $request, $fabric = null){
        $items = $this->getItems($request, null, null, $fabric, null);
        if(isset($fabric)){
            $fabric = $this->itemPropertyRepo->getFabricBySlug($fabric);
            $title = $fabric->name;
            $selected = $fabric->id;
        }
        else{
            $title = 'Styles in '.$fabric->name .' fabric';
            $selected = 0;
        }
        if($request->has('sort'))
            $order = $request->input('sort');
        else
            $order = $this->defaultSort;
        SEO::setTitle($title);
        $viewData = [
          'items' => $items,
          'selected' => $selected,
          'order' => $order,
        ];
        if(isset($style) && (!$request->has('page') || $request->input('page') == '1'))
            $this->statRepo->styleViewed($style->id, auth()->id());
        return view('item.portfolio', $viewData);
    }

    private function getItems(Request $request, $category = null, $style = null, $fabric = null, $color = null){
        $filters = array();
        $order = array();
        if($request->has('limit'))
            $limit = $request->input('limit');
        else
            $limit = $this->limit;
        $order['orderDir'] = 'desc';
        if($request->has('sort')){
            if($request->input('sort') == 'recommended'){
                $order['orderBy'] = 'created_at';
                return $this->itemRepo->getRecommendedItems(auth()->id(), $order, $limit);
            }
            elseif ($request->input('sort') == 'popular') {
                //$order_by = $request->input('sort');
                $order['orderBy'] = $this->popularOrder;
            }
        }
        else
            $order['orderBy'] = $this->defaultOrder;
    	if(isset($category))
    		$filters['category'] = $category;
    	if(isset($style))
    		$filters['style'] = $style;
    	if(isset($fabric))
    		$filters['fabric'] = $fabric;
    	if(isset($color))
    		$filters['color'] = $color;
    	return $this->itemRepo->getItems($filters, $order, $limit);
    }

    public function searchItems(Request $request){
    	$order = array();
        if($request->has('limit'))
            $limit = $request->input('limit');
        else
    	   $limit = $this->limit;
    	if($request->has('order_by'))
    		$order['orderBy'] = $request->input('order_by');
    	if($request->has('order_by'))
    		$order['orderDir'] = $request->input('order_dir');
    	$items = $this->itemRepo->searchItems(strtolower($request->input('q')), $order, $limit);
        SEO::setTitle('Search results for \''. $request->input('q') .'\'');
        $viewData = [
          'items' => $items,
          'term' => $request->input('q'), 
        ];
        if(!$request->has('page') || $request->input('page') == '1')
            $this->statRepo->itemSearched($request->input('q'), $items->total(), auth()->id());
        return view('item.search', $viewData);
    }
}
