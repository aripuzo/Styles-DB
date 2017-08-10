<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function items()
    {
        return $this->bolongsToMany('App\Models\Item', 'item_tag');
    }
}
