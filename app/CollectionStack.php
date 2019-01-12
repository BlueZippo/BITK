<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionStack extends Model
{
    public function collection()
    {
    	return $this->hasMany('App\Collection', 'collection_id')
    }

    public function stack()
    {
    	return $this->hasMany('App\Stack', 'stack_id');
    }
}
