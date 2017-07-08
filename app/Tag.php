<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function itemTags()
    {
        return $this->hasMany('App\ItemTag');
    }

    public function items()
    {
        return $this->hasManyThrough('App\Items', 'App\ItemTag');
    }
}
