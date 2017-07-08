<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemColor extends Model
{
    protected $table = 'item_color';

    public function color(){
        return $this->belongsTo('App\Color');
    }

    public function style(){
        return $this->belongsTo('App\Style');
    }
}
