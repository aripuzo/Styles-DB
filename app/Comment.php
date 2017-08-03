<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    protected $table = 'comments';

    public function item(){
        return $this->belongsTo('App\Item');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function parent(){
        return $this->belongsTo('App\Comment', 'parent_id');
    }

    public function subComments(){
        return $this->hasMany('App\Comment', 'parent_id');
    }

    public function getTimeAgo(){
    	$dt = Carbon::parse($this->created_at);
    	return $dt->diffForHumans(Carbon::now());
    }
}
