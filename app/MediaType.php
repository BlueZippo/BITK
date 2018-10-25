<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
    protected $fillable = ['media_type'];

    protected $table = 'media_types';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function link()
    {
    	return $this->belongsTo('App\Link');
    }
}
