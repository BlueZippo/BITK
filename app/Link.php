<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function follow()
    {
    	return $this->belongsToMany('App\LinksFollow');
    }

    public function category()
    {
        return $this->belongsToMany('App\Category', 'link_categories');
    }


    public function stack()
    {
        return $this->belongsToMany('App\Stack', 'stack_links');
    }
}
