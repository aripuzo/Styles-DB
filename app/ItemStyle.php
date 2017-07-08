<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemStyle extends Model
{
    protected $table = 'item_style';

    public function style(){
        return $this->belongsTo('App\Style');
    }

    public function item(){
        return $this->belongsTo('App\Item');
    }
}
