<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }
}
