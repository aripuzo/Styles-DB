<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

    public function itemCategories()
    {
        return $this->hasMany('App\Models\ItemCategory');
    }

    public function items()
    {
        return $this->hasManyThrough('App\Models\Items', 'App\Models\ItemCategory');
    }
}
