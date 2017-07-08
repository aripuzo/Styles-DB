<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $table = 'item_category';

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function item(){
        return $this->belongsTo('App\Item');
    }
}
