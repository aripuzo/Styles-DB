<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function item_colors()
    {
        return $this->hasMany('App\ItemColor');
    }

    public function items()
    {
        return $this->hasManyThrough('App\Item', 'App\ItemColor');
    }
}
