<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WhatsNew extends Model
{
	protected $fillable = ['title', 'subtitle', 'published_date', 'type', 'content', 'excerpt'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
