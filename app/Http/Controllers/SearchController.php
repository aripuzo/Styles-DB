<?php

namespace App\Http\Controllers;

use App\Repository\Contracts\ItemPropertyRepository;
use App\Repository\Contracts\ItemRepository;
use App\Repository\Contracts\StatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use SEO;

//!TAMuno__123
//6Sy'eejZH5r4P}{E

class SearchController extends Controller {
	//
	private $itemRepo;
	private $itemPropertyRepo;
	private $statRepo;
	private $limit;

	public function __construct(ItemRepository $itemRepo, StatRepository $statRepo, ItemPropertyRepository $itemPropertyRepo) {
		$this->itemRepo = $itemRepo;
		$this->itemPropertyRepo = $itemPropertyRepo;
		$this->statRepo = $statRepo;
		$this->limit = config('settings.limit');
	}

	public function search(Request $request) {
		$order = array();
		if ($request->has('limit')) {
			$limit = $request->input('limit');
		} else {
			$limit = $this->limit;
		}

		if ($request->has('order_by')) {
			$order['orderBy'] = $request->input('order_by');
		}

		if ($request->has('order_by')) {
			$order['orderDir'] = $request->input('order_dir');
		}
		if ($request->has('cat')) {
			$category = $request->input('cat');
		} else {
			$category = 0;
		}

		$items = $this->itemRepo->searchItems(strtolower($request->input('q')), $category, $order, $limit);
		if (\Request::ajax()) {
			$view = view('item.partials.data', compact('items'))->render();
			return response()->json(['result' => true, 'html' => $view]);
		}
		SEO::setTitle('Search results for \'' . $request->input('q') . '\'');
		$viewData = [
			'items' => $items,
			'term' => $request->input('q'),
			'cat' => $category,
			'categories' => $this->itemPropertyRepo->getCategories(),
		];
		if (!$request->has('page') || $request->input('page') == '1') {
			$this->statRepo->itemSearched($request->input('q'), $items->total(), auth()->id());
		}

		return view('item.search', $viewData);
	}

	public function searchSuggestion(Request $request) {
		$query = $request->get('query', '');
		$posts = $this->statRepo->searchSuggestion($query);
		$value = '<ul id="search-list">';
		foreach ($posts as $ar) {
			$value .= '<li onClick="selectSearch(\'' . $ar . '\');">' . $ar . '</li>';
		}
		$value .= '</ul>';
		return response()->json($posts);
	}
}
