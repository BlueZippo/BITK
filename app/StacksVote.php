<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StacksVote extends Model
{
    public function stack()
    {
    	$this->belongsTo('App\Stack');
    }

    public function user()
    {
    	$this->belongsTo('App\User');
    }
}
