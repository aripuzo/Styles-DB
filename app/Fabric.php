<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    public function itemFabrics()
    {
        return $this->hasMany('App\ItemFabric');
    }

    public function items()
    {
        return $this->hasManyThrough('App\Item', 'App\ItemFabric');
    }
}
