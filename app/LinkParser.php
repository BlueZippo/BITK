<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkParser extends Model
{
    protected $fillable = ['domain', 'title', 'description', 'image', 'category', 'lookup'];

    protected $table = 'link_parsers';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function media_type()
    {
    	return $this->hasOne('App\MediaType', 'id', 'category');
    }
}
