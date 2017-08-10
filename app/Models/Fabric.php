<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    public function itemFabrics()
    {
        return $this->hasMany('App\Models\ItemFabric');
    }

    public function items()
    {
        return $this->hasManyThrough('App\Models\Item', 'App\Models\ItemFabric');
    }
}
