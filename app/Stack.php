<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stack extends Model {

    protected $fillable = ['title', 'content'];


    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function link()
    {
    	return $this->belongsTo('App\Link');
    }

    public function links()
    {
    	return $this->belongsToMany('App\Link', 'stack_links');
    }


  

}