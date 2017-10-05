<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Contracts\ItemRepository;
use App\Repository\Contracts\UserRepository;
use App\Serializers\MySerializer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ActorController extends Controller {
	public $userRepo;
	public $itemRepo;
	private $fractal;
	private $userTransformer;
	private $limit;

	public function __construct(UserRepository $userRepo, ItemRepository $itemRepo, Manager $fractal, UserTransformer $userTransformer) {
		$this->userRepo = $userRepo;
		$this->itemRepo = $itemRepo;
		$this->fractal = $fractal;
		$this->fractal->setSerializer(new MySerializer());
		$this->userTransformer = $userTransformer;

		$this->limit = config('settings.limit');
	}

	public function index() {
		if ($request->has('limit')) {
			$limit = $request->input('limit');
		} else {
			$limit = $this->limit;
		}
		$userPaginator = $this->userRepo->getUsers($limit);
		$users = new Collection($userPaginator->items(), $this->userTransformer); // Create a resource collection transformer
		$users->setPaginator(new IlluminatePaginatorAdapter($usersPaginator));

		$this->fractal->parseIncludes($request->get('include', ''));

		$users = $this->fractal->createData($users); // Transform data
		return $users->toArray();
	}

	public function show($id) {
		$user = $this->userRepo->getUser($id);
		if (!$user) {
			return Response::json([
				'error' => [
					'message' => 'Not found!',
					'status_code' => 404,
				],
			], 404);
		}
		$user = new Item($user, $this->userTransformer);
		$user = $this->fractal->createData($user); // Transform data
		return $user->toArray();
	}

	public function update(Request $request) {
		if ($request->input('password') != null) {
			$this->validate($request, [
				'old_password' => 'required|string|min:6',
				'password' => 'required|string|min:6|confirmed',
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

	public function postUpload() {
		$form_data = Input::all();

		$validator = Validator::make($form_data, [
			'img' => 'required|mimes:png,gif,jpeg,jpg,bmp',
		],
			[
				'img.mimes' => 'Uploaded file is not in image format',
				'img.required' => 'Image is required',
			]);

		if ($validator->fails()) {

			return Response::json([
				'status' => 'error',
				'message' => $validator->messages()->first(),
			], 200);

		}

		$photo = $form_data['img'];

		$image = $this->userRepo->updatePhoto(auth()->id(), $photo);

		if (!$image) {
			return Response::json([
				'status' => 'error',
				'message' => 'Server error while uploading',
			], 200);
		}

		return Response::json([
			'status' => 'success',
			'url' => env('URL') . 'uploads/' . $this->userRepo->getUser($userId)->avatar, //$filename_ext,
			'width' => $image->width(),
			'height' => $image->height(),
		], 200);
	}

	public function getBookmarks() {
		$user = $this->userRepo->getUser(auth()->id());
		$items = array();
		foreach ($user->bookmarks as $bookmark) {
			$items[] = $bookmark->item;
		}
		$viewData = [
			'items' => $items,
		];
		SEO::setTitle($user->getTitle() . ' Bookmarks');
		return view('user.bookmarks', $viewData);
	}
}
