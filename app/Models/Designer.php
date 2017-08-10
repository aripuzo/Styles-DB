<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
	protected $table = 'designer';

    public function items(){
        return $this->hasMany('App\Models\Item');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function getLink(){
        return '#';
    }
}
