<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Style extends Model {
	public function items() {
		return $this->belongsToMany('App\Models\Item', 'item_style');
	}

	public function style() {
		return $this->belongsTo('App\Models\Style', 'parent_id');
	}

	public function hasCategoryItems($categoryId) {
		// Items::whereIn($this->items->pluck('id')->toArray())->whereHas('categories',function ($q) use ($city_id){
		//       $q->whereHas('cities', function ($q) use ($city_id){
		//           $q->where('id', $city_id);
		//        });
		//    })->get();
		if (!isset($this->items) && $this->items->count() == 0) {
			return false;
		}

		$arr = Item::whereIn('items.id', $this->items->pluck('id')->toArray())->whereHas('categories', function ($q) use ($categoryId) {
			$q->where('categories.id', $categoryId);
		})->get();
		return (isset($arr) && $arr->count() > 0);
	}

	public function getSEOTitle() {
		return $this->name . ' styles';
	}

	public function getSEODescription() {
		return $this->getSEOTitle();
	}

	public function getSEOKeywords() {
		$keywords = [$this->name];
		return $keywords;
	}
}
