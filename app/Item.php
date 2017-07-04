<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function categories()
    {
        return $this->hasManyThrough('App\Category', 'App\ItemCategory');
    }

    public function styles()
    {
        return $this->hasManyThrough('App\Style', 'App\ItemStyle');
    }

    public function fabrics()
    {
        return $this->hasManyThrough('App\Fabric', 'App\ItemFabric');
    }

    public function categories()
    {
        return $this->hasManyThrough('App\Category', 'App\ItemCategory');
    }

    public function colors()
    {
        return $this->hasManyThrough('App\Color', 'App\ItemColor');
    }
}
