<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
