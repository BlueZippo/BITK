<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StacksVote extends Model
{
    public function stack()
    {
    	return $this->belongsTo('App\Stack', 'stack_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
