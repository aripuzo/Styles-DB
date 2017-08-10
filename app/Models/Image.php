<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }
}
