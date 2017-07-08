<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemBookmark extends Model
{
    protected $table = 'item_bookmark';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function item(){
        return $this->belongsTo('App\Item');
    }
}
