<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkComment extends Model
{
   protected $fillable = ['link_id', 'comment', 'user_id'];


    public function link()
    {
    	return $this->belongsTo('App\Link');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
