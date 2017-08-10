<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemDownload extends Model
{
    protected $table = 'downloads';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }
}
