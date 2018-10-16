<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeopleFollow extends Model
{
    public function user()
    {
        $this->belongsTo('App\User');
    }
}
