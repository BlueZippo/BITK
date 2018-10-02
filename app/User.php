<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id', 'photo'
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
     * Add a mutator to ensure hashed passwords
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function links()
    {
        return $this->hasMany('App\Link');
    }

    public function linksFollow()
    {
        return $this->belongsToMany('App\Link', 'links_follows', 'user_id');
    }

    public function stacks()
    {
        return $this->hasMany('App\Stack');
    }


    public function stacksFollow()
    {
         return $this->hasManyThrough('App\StacksFollow', 'App\Stack', 'id', 'user_id');
    }


    public function tags()
    {
        return $this->hasMany('App\Tag');
    }

}
