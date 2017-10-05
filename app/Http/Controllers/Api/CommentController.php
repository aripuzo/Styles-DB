<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Contracts\ItemRepository;
use App\Repository\Contracts\UserRepository;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class CommentController extends Controller {
	public $userRepo;
	public $itemRepo;
	private $fractal;
	private $commentTransformer;
	private $limit;

	public function __construct(UserRepository $userRepo, ItemRepository $itemRepo, Manager $fractal, CommentTransformer $commentTransformer) //inject repositories
	{
		$this->userRepo = $userRepo;
		$this->itemRepo = $itemRepo;
		$this->fractal = $fractal;
		$this->commentTransformer = $commentTransformer;

		$this->limit = config('settings.limit');
	}

	public function index($id) {
		$item = $this->itemRepo->getItem($id);
		if (!isset($item)) {
			return response()->json([
				'error' => [
					'message' => 'Not found!',
					'status_code' => 404,
				],
			], 404);
		}
		$comments = $item->comments;
		if ($comments->count() <= 0) {
			return array();
		}

		$comments = new Collection($comments->items(), $this->commentTransformer); // Create a resource collection transformer
		$comments->setPaginator(new IlluminatePaginatorAdapter($comments));

		$comments = $this->fractal->createData($comments); // Transform data
		return $comments->toArray();
	}

	public function create(Request $request) {
		$this->validate($request, [
			'id' => 'required|numeric|exists:items',
			'text' => 'required',
		]);
		$value = $this->itemRepo->commentOnItem(auth()->id(), $request->input('id'), $request->input('text'), $request->input('comment_id'));
		return redirect()->action(
			'ItemController@getItem', ['id' => $request->input('id')]
		);
	}

}
