<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    protected $table = 'comments';

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function parent(){
        return $this->belongsTo('App\Models\Comment', 'parent_id');
    }

    public function subComments(){
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }

    public function getTimeAgo(){
    	$dt = Carbon::parse($this->created_at);
    	return $dt->diffForHumans(Carbon::now());
    }
}
