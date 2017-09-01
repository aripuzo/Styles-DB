<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fabric extends Model {

	public function items() {
		return $this->belongsToMany('App\Models\Item', 'item_fabric');
	}

	public function hasCategoryItems($categoryId) {
		if (!isset($this->items) && $this->items->count() == 0) {
			return false;
		}

		$arr = Item::whereIn('items.id', $this->items->pluck('id')->toArray())->whereHas('categories', function ($q) use ($categoryId) {
			$q->where('categories.id', $categoryId);
		})->get();
		return (isset($arr) && $arr->count() > 0);
	}

	public function getSEOTitle() {
		return $this->name . ' styles| Styles in ' . $this->name . ' fabric';
	}

	public function getSEODescription() {
		return $this->getSEOTitle();
	}

	public function getSEOKeywords() {
		$keywords = [$this->name];
		return $keywords;
	}
}
