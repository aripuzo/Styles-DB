<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Item extends Model
{
    use SoftDeletes;

    public function styles(){
        return $this->belongsToMany('App\Style', 'item_style')->withTimestamps();
    }

    public function categories(){
        return $this->belongsToMany('App\Category', 'item_category')->withTimestamps();
    }

    public function fabrics(){
        return $this->belongsToMany('App\Fabric', 'item_fabric');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag', 'item_tag');
    }

    public function bookmarks()
    {
        return $this->hasMany('App\ItemBookmark');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function colors()
    {
        return $this->belongsToMany('App\Color', 'item_color');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }

    public function downloads()
    {
        return $this->hasMany('App\ItemDownload');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function designer()
    {
        return $this->belongsTo('App\Designer');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    public function getName(){
        if(isset($this->name))
            return $this->name;
        $name = '';
        if(isset($this->fabrics) && $this->fabrics->count() > 0){
            $i = 0;
            foreach($this->fabrics as $fabric){
                if($i > 0)
                    if($i == $this->fabrics->count() - 1)
                        $name .= 'and ';
                    else
                        $name .= ', ';
                $name .= $fabric->name.' ';
                $i++;
            }
        }
        if(isset($this->styles) && $this->styles->count() > 0 )
            $i = 0;
            foreach($this->styles as $style){
                if($i > 0)
                    if($i == $this->styles->count() - 1)
                        $name .= 'and ';
                    else
                        $name .= ', ';
                $name .= $style->name.' ';
                $i++;
            }
        return $name;
    }

    public function getSEOTitle(){
        return $this->categories->first()->name. ' | ' . $this->getName();
    }

    public function getURLName(){
        return urlencode($this->getName());
    }

    public function getURL(){
        return urlencode($this->getName());
    }

    public function getSEODescription(){
        return $this->description;
    }

    public function getCategoriesLabel(){
        $s = '';
        $i = 0;
        foreach($this->categories as $category){
            if($i > 0)
                $s .= '<span>,</span></li>';
            $s .= '<li>' . $category->name;
            $i++;
        }
        echo $s.'</li>';
    }

    public function getCategoryLabel(){
        return $this->categories->first()->name;
    }

    public function getFabricsLabel(){
        $s = '';
        $i = 0;
        foreach($this->fabrics as $fabric){
            if($i > 0)
                $s .= ', ';
            $s .= $fabric->name;
            $i++;
        }
        return $s;
    }

    public function getDownloadsLabel(){
        return isset($this->downloads) && $this->downloads->sum('count') > 0 ? $this->downloads->sum('count') : '';
    }

    public function getBookmarksLabel(){
        return $this->bookmarks->count() > 0 ? $this->bookmarks->count() : '';
    }

    public function getLikesLabel(){
        return $this->favorites->count() > 0 ? $this->favorites->count() : '';
    }

    public function getCommentsLabel(){
        return $this->comments->count() > 0 ? $this->comments->count() : '';
        //https://graph.facebook.com/v2.4/?fields=share{comment_count}&amp;id=<YOUR_URL>
    }

    public function getCommentsLabelSingle(){
        return ($this->comments->count() > 0 ? $this->comments->count() : 'No').' comment(s)';
        //https://graph.facebook.com/v2.4/?fields=share{comment_count}&amp;id=<YOUR_URL>
    }

    public function getAverageRating(){
        return $this->ratings->avg('rating');
    }

    public function getImage(){
        if(isset($this->images->first()->url))
        return $this->images->first()->url;
    }

    public function getUserName(){
        if(isset($this->user))
            return $this->user->getName();
        else
            return 'House';
    }

    public function getUserLink(){
        if(isset($this->user))
            return $this->user->getLink();
        else
            return '#';
    }

    public function getCreatedAt(){
        $dt = Carbon::parse($this->created_at);
        //return $this->created_at;
        return  $dt->toFormattedDateString();
    }

}
