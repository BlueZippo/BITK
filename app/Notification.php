<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

	protected $fillable = ['status'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }


    public function person()
    {
    	return $this->belongsTo('App\User', 'person_id');
    }

    public function stack()
    {
    	return $this->belongsTo('App\Stack', 'item_id');
    }

    public function link()
    {
    	return $this->belongsTo('App\Link', 'item_id');
    }
}
