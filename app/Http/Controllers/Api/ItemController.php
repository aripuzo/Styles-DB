<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Controller;
use App\Repository\Contracts\ItemRepository;
use App\Repository\Contracts\StatRepository;
use App\Repository\Contracts\UserRepository;
use App\Serializers\MySerializer;
use App\Transformers\ItemTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ItemController extends Controller {
	//
	private $itemRepo;
	private $statRepo;
	private $userRepo;
	private $limit;
	private $defaultSort;
	private $defaultOrder;
	private $popularOrder = 'ratings'; //'favorites';
	private $fractal;
	private $itemTransformer;

	public function __construct(ItemRepository $itemRepo, UserRepository $userRepo, StatRepository $statRepo, Manager $fractal, ItemTransformer $itemTransformer) {
		$this->itemRepo = $itemRepo;
		$this->statRepo = $statRepo;
		$this->userRepo = $userRepo;
		$this->fractal = $fractal;
		$this->fractal->setSerializer(new MySerializer());
		$this->itemTransformer = $itemTransformer;

		$this->limit = config('settings.limit');
		$this->defaultSort = config('settings.defaultSort');
		$this->defaultOrder = config('settings.defaultOrder');
		$this->popularOrder = config('settings.popularOrder');
	}

	private function getItems(Request $request, $filters, $order) {
		if ($request->has('category')) {
			$filters['category'] = $request->input('category');
		}

		if ($request->has('style')) {
			$filters['style'] = $request->input('style');
		}

		if ($request->has('fabric')) {
			$filters['fabric'] = $request->input('fabric');
		}

		if ($request->has('color')) {
			$filters['color'] = $request->input('color');
		}
		$itemsPaginator = $this->itemRepo->getItems($filters, $order, $request->has('limit') ? $request->input('limit') : $this->limit);
		$items = new Collection($itemsPaginator->items(), $this->itemTransformer, 'data'); // Create a resource collection transformer
		$items->setPaginator(new IlluminatePaginatorAdapter($itemsPaginator));

		$this->fractal->parseIncludes($request->get('include', ''));

		$items = $this->fractal->createData($items); // Transform data
		return $items->toArray();
	}

	public function index(Request $request) {
		$filters = array();
		$order = array();

		$order['orderDir'] = 'desc';
		if ($request->has('sort')) {
			if ($request->input('sort') == 'recommended') {
				$order['orderBy'] = 'created_at';
				return $this->itemRepo->getRecommendedItems(auth()->id(), $order, $limit);
			} elseif ($request->input('sort') == 'popular') {
				$order['orderBy'] = $this->popularOrder;
			}
		} else {
			$order['orderBy'] = $this->defaultOrder;
		}
		return $this->getItems($request, $filters, $order);
	}

	public function latest(Request $request) {
		$filters = array();
		$order = array();

		$order['orderBy'] = 'created_at';
		$order['orderDir'] = 'desc';
		return $this->getItems($request, $filters, $order);
	}

	public function popular(Request $request) {
		$filters = array();
		$order = array();

		$order['orderBy'] = 'favorites';
		$order['orderDir'] = 'desc';
		return $this->getItems($request, $filters, $order);
	}

	public function topRated(Request $request) {
		$filters = array();
		$order = array();

		$order['orderBy'] = 'ratings';
		$order['orderDir'] = 'desc';
		return $this->getItems($request, $filters, $order);
	}

	public function topDownloads(Request $request) {
		$filters = array();
		$order = array();

		$order['orderBy'] = 'ratings';
		$order['orderDir'] = 'desc';
		return $this->getItems($request, $filters, $order);
	}

	public function recommended(Request $request) {
		$filters = array();
		$order = array();

		$order['orderBy'] = 'created_at';
		$order['orderDir'] = 'desc';

		$itemsPaginator = $this->itemRepo->getRecommendedItems(Auth::guard('api')->user()->id, $request->has('limit') ? $request->input('limit') : $this->limit);
		$items = new Collection($itemsPaginator->items(), $this->itemTransformer, 'data'); // Create a resource collection transformer
		$items->setPaginator(new IlluminatePaginatorAdapter($itemsPaginator));

		$this->fractal->parseIncludes($request->get('include', ''));

		$items = $this->fractal->createData($items); // Transform data
		return $items->toArray();
	}

	public function similar(Request $request, $id) {
		$itemsPaginator = $this->itemRepo->getSimilarItems($id, $request->has('limit') ? $request->input('limit') : 5);
		$items = new Collection($itemsPaginator->items(), $this->itemTransformer, 'data'); // Create a resource collection transformer
		$items->setPaginator(new IlluminatePaginatorAdapter($itemsPaginator));

		$this->fractal->parseIncludes($request->get('include', ''));

		$items = $this->fractal->createData($items); // Transform data
		return $items->toArray();
	}

	public function bookmarks(Request $request, $id) {
		$user = $this->userRepo->getUser($id);
		if (!$user) {
			return Response::json([
				'error' => [
					'message' => 'Not found!',
					'status_code' => 404,
				],
			], 404);
		}
		if ($user->bookmarks->count() <= 0) {
			return array();
		}
		$itemsPaginator = $user->bookmarks;
		$items = new Collection($itemsPaginator->items(), $this->itemTransformer, 'data');
		$items->setPaginator(new IlluminatePaginatorAdapter($itemsPaginator));

		$this->fractal->parseIncludes($request->get('include', ''));

		$items = $this->fractal->createData($items); // Transform data
		return $items->toArray();
	}

	public function myItems(Request $request, $id) {
		if (!$user) {
			return Response::json([
				'error' => [
					'message' => 'Not found!',
					'status_code' => 404,
				],
			], 404);
		}
		if ($user->items->count() <= 0) {
			return array();
		}
		$itemsPaginator = $user->items;
		$items = new Collection($itemsPaginator->items(), $this->itemTransformer, 'data'); // Create a resource collection transformer
		$items->setPaginator(new IlluminatePaginatorAdapter($itemsPaginator));

		$this->fractal->parseIncludes($request->get('include', ''));

		$items = $this->fractal->createData($items); // Transform data
		return $items->toArray();
	}

	public function show($id) {
		$item = $this->itemRepo->getItem($id);
		if (!$item) {
			return response()->json([
				'error' => [
					'message' => 'Not found!',
					'status_code' => 404,
				],
			], 404);
		}
		$this->statRepo->itemViewed($id, auth()->id());
		$item = new Item($item, $this->itemTransformer);
		$item = $this->fractal->createData($item); // Transform data
		return $item->toArray();
	}

	public function create(Request $request) {
		$data = array(
			'add_categories' => $row['categories'],
			'add_styles' => $row['styles'],
			'add_fabrics' => $row['fabrics'],
			'add_colors' => $row['colors'],
			'add_tags' => $row['tags'],
			'parent' => $row['parent'],
			'designer' => $row['designer'],
		);
		$validator = Validator::make($request->all(), [
			'categories' => 'required',
			'styles' => 'required',
			'image' => 'required',
			'fabrics' => 'required',
		]);
		if ($validator->fails()) {
			return Response::json([
				'error' => [
					'message' => $validator->messages(),
					'status_code' => 422,
				],
			], 422);
		}

		$images = array();
		$files = Request::file('image');
		foreach ($files as $file) {
			$images[] = $this->uploadFile($file);
		}

		$user = Auth::guard('api')->user();

		$request->merge(['user_id' => $user->id, 'images' => $images]);

		$item = $this->itemRepo->addItem($request->all());
	}

	private function uploadFile($file) {
		Cloudder::upload($file);
		$c = Cloudder::getResult();
		if ($c) {
			return $c['url'];
		}
	}

	private function saveImage($name, $id, $request) {
		$image = $request->file($name);
		$imageName = md5(microtime()) . '_' . $id . '.' . $image->getClientOriginalExtension();
		$image->move(public_path('ustyles/pic/images'), $imageName);
		return $imageName;
		// $rules = [
		//           'name' => 'required'
		//       ];
		//       $photos = count($this->input('photos'));
		//       foreach(range(0, $photos) as $index) {
		//           $rules['photos.' . $index] = 'image|mimes:jpeg,bmp,png|max:2000';
		//       }

		//       return $rules;
	}

	public function delete($id) {
		$itemRepo->deleteItem($id);
		return 204;
	}

	public function update(Request $request, $id) {
		$itemRepo->deleteItem($id);
		return 204;
	}

	public function favItem(Request $request) {
		$this->validate($request, [
			'id' => 'required|numeric|exists:items',
		]);
		Log::info('User favorite item.', ['user_id' => auth()->id(), 'item_id' => $request->input('id')]);
		$value = $this->itemRepo->favItem(auth()->id(), $request->input('id'));
		if ($value) {
			return response()->json(['response' => true, 'value' => $value]);
		} else {
			return response()->json(['response' => false, 'message' => 'Error occured']);
		}

	}

	public function bookmarkItem(Request $request) {
		$this->validate($request, [
			'id' => 'required|numeric|exists:items',
		]);
		Log::info('User bookmark item.', ['user_id' => auth()->id(), 'item_id' => $request->input('id')]);
		$value = $this->itemRepo->bookmarkItem(auth()->id(), $request->input('id'));
		if ($value) {
			return response()->json(['response' => true, 'value' => $value]);
		} else {
			return response()->json(['response' => false, 'message' => 'Error occured']);
		}

	}

	public function downloadItem(Request $request) {
		$this->validate($request, [
			'id' => 'required|numeric|exists:items',
		]);
		$pathToFile = $this->itemRepo->downloadItem(auth()->id(), $request->input('id'));
		if (isset($pathToFile)) {
			return response()->json(['response' => true, 'url' => $pathToFile, 'filename' => $this->itemRepo->getItem($request->input('id'))->name . '.jpg']);
		} else {
			return response()->json(['response' => false, 'message' => 'Error occured']);
		}

	}
}
