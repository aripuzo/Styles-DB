<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
	use SoftDeletes;

	public function getSEOTitle() {
		return $this->name . ' styles | Styles for ' . $this->name;
	}

	public function getSEODescription() {
		return $this->getSEOTitle();
	}

	public function getSEOKeywords() {
		$keywords = [$this->name];
		return $keywords;
	}
}
