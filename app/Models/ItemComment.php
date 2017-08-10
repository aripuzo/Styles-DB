<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemComment extends Model
{
    protected $table = 'item_comment';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function item(){
        return $this->belongsTo('App\Item');
    }
}
