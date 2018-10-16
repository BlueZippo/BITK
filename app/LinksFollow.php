<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinksFollow extends Model
{
    protected $table = 'links_follows';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function links()
    {
    	return $this->belongsToMany('App/Link');
    }

    public function user()
    {
    	return $this->belongsToMany('App\User');
    }


}
