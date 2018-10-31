<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StackComments extends Model
{
    protected $fillable = ['stack_id', 'comment', 'user_id'];


    public function stack()
    {
    	return $this->belongsTo('App\Stack');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
