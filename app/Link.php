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
        return $this->belongsToMany('App\Category', 'link_categories', 'link_id', 'category_id');
    }


    public function stack()
    {
        return $this->belongsTo('App\Stack');
    }

    public function media()
    {
        return $this->belongsTo('App\MediaType');
    }

    public function get_host($link)
    {
        $url = parse_url($link);

        return $url['host'];
    }


    public function comments()
    {
        return $this->hasMany('App\LinkComment');
    }
}
