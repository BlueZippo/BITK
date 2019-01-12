<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeopleFollow extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function people()
    {
    	return $this->belongsTo('App\User', 'people_id');
    }
}
