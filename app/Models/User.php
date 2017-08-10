<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use App\Traits\HasGravatar;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasGravatar;
    use HasRoleAndPermission;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'sex', 'token','activated',
        'signup_ip_address',
        'signup_confirmation_ip_address',
        'signup_sm_ip_address',
        'admin_ip_address',
        'updated_ip_address',
        'deleted_ip_address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token', 'activated',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function requests()
    {
        return $this->hasMany('App\Models\Request');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function downloads()
    {
        return $this->hasMany('App\Models\Download');
    }

    public function bookmarks()
    {
        return $this->hasMany('App\Models\Bookmark');
    }

    public function favorites()
    {
        return $this->hasMany('App\Models\Favorite');
    }

    public function social(){
        return $this->hasOne('App\Models\SocialAccount');
    }

    public function designer(){
        return $this->hasOne('App\Models\Designer');
    }

    public function designers(){
        return $this->belongsToMany('App\Models\Designer')->withTimestamps();
    }

    public function items(){
        return $this->hasMany('App\Models\Item');
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
            return 'https://graph.facebook.com/' . $this->social->provider_user_id . '/picture';
        return $this->gravatar;
    }

    public function getLink(){
        return '#';
    }

    public function assignDesigner($designer)
    {
        return $this->designers()->attach($designer);
    }

    public function removeDesigner($designer)
    {
        return $this->designers()->detach($designer);
    }
}
