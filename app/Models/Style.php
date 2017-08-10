<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'item_style');
    }
}
