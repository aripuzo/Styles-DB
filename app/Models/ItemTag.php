<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTag extends Model
{
    protected $table = 'item_tag';

    public function tag()
    {
        return $this->belongsTo('App\Tag');
    }

    public function item(){
        return $this->belongsTo('App\Item');
    }
}
