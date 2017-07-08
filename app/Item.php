<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function itemStyles()
    {
        return $this->hasMany('App\ItemStyle');
    }

    public function itemCategories()
    {
        return $this->hasMany('App\ItemCategory');
    }

    public function itemFabrics()
    {
        return $this->hasMany('App\ItemFabric');
    }

    public function itemTags()
    {
        return $this->hasMany('App\ItemTag');
    }

    public function itemColors()
    {
        return $this->hasMany('App\ItemColor');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function downloads()
    {
        return $this->hasMany('App\ItemDownload');
    }

    public function likes()
    {
        return $this->hasMany('App\Favorite');
    }

    public function getSEOTitle(){
        return $this->name . ' | ' . $this->itemCategories->first()->category->name . ' | ' . $this->itemFabrics->first()->fabric->name;
    }

    public function getSEODescription(){
        return $this->description;
    }

    public function getCategoriesLabel(){
        $s = '';
        $i = 0;
        foreach($this->itemCategories as $itemCategory){
            if($i > 0)
                $s .= ', ';
            $s .= $itemCategory->category->name;
            $i++;
        }
        return $s;
    }

    public function getFabricsLabel(){
        $s = '';
        $i = 0;
        foreach($this->itemFabrics as $ItemFabric){
            if($i > 0)
                $s .= ', ';
            $s .= $ItemFabric->fabric->name;
            $i++;
        }
        return $s;
    }

    public function getDownloadsLabel(){
        return $this->downloads->count() > 0 ? $item->likes->count() : '';
    }

    public function getLikesLabel(){
        return $this->likes->count() > 0 ? $item->likes->count() : '';
    }

    public function getImage(){
        return $this->images->first()->url;
    }

}
