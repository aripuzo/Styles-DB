<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemDownload extends Model
{
    protected $table = 'item_download';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function item(){
        return $this->belongsTo('App\Item');
    }
}
