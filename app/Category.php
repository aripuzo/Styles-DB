<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function itemCategories()
    {
        return $this->hasMany('App\ItemCategory');
    }

    public function items()
    {
        return $this->hasManyThrough('App\Items', 'App\ItemCategory');
    }
}
