<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
	protected $table = 'designer';
    public function items(){
        return $this->hasMany('App\Item');
    }
}
