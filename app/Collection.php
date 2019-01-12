<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['title']; 


    public function stacks() {
    	return $this->belongsToMany('App\Stack', 'collection_stacks', 'collection_id', 'stack_id');
    }
}
