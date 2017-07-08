<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemFabric extends Model
{
    protected $table = 'item_fabric';

    public function fabric()
    {
        return $this->belongsTo('App\Fabric');
    }

    public function item(){
        return $this->belongsTo('App\Item');
    }
}
