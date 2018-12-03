<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['cat_name'];

    protected $table = 'categories';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function link()
    {
    	return $this->belongsTo('App\Link');
    }


    public function StackCategory()
    {
    	return $this->hasOne('App\StackCategory');
    }

}
