<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasGravatar;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasGravatar;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'sex',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function requests()
    {
        return $this->hasMany('App\Request');
    }

    public function comments()
    {
        return $this->hasManyThrough('App\ItemComment', 'App\Comment');
    }

    public function downloads()
    {
        return $this->hasMany('App\ItemDownload');
    }

    public function bookmarks()
    {
        return $this->hasMany('App\ItemBookmark');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    public function social(){
        return $this->hasOne('App\SocialAccount');
    }

    public function items(){
        return $this->hasMany('App\Item');
    }

    public function getTitle(){
        return $this->getName();
    }

    public function getName(){
        if(isset($this->name))
            return $this->name;
        return $this->username;
    }

    public function getAvatar(){
        if(isset($this->avatar))
            return $this->avatar;
        elseif(isset($this->social) && $this->social->provider == 'facebook')
            return 'https://graph.facebook.com/' . $this->scoial->provider_user_id . '/picture';
        return $this->gravatar;
    }

    public function getLink(){
        return '#';
    }
}
