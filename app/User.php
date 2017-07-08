<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
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

    public function items()
    {
        return $this->hasManyThrough('App\Item', 'App\ItemBookmark');
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
}
