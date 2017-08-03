<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

    public function itemCategories()
    {
        return $this->hasMany('App\ItemCategory');
    }

    public function items()
    {
        return $this->hasManyThrough('App\Items', 'App\ItemCategory');
    }
}
