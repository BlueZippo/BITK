<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
	protected $fillable = ['confirmed', 'email'];    

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
