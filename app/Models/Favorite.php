<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }
}
