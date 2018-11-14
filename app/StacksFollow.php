<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StacksFollow extends Model
{
    public function stacks()
    {
    	$this->belongsToMany('App\Stack');
    }

    public function users()
    {
    	$this->belongsToMany('App\User');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function stack()
    {
    	return $this->belongsTo('App\Stack');
    }
}
