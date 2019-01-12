<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionStack extends Model
{
    public function collections()
    {
    	return $this->hasMany('App\Collection', 'collection_id');
    }

    public function stacks()
    {
    	return $this->hasMany('App\Stack');
    }
}
