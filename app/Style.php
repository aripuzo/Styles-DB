<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    public function itemStyles()
    {
        return $this->hasMany('App\ItemStyle');
    }

    public function items()
    {
        return $this->hasManyThrough('App\Item', 'App\ItemStyle');
    }
}
