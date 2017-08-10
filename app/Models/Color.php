<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function item_colors()
    {
        return $this->hasMany('App\Models\ItemColor');
    }

    public function items()
    {
        return $this->hasManyThrough('App\Models\Item', 'App\Models\ItemColor');
    }
}
