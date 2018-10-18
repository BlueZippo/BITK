<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = ['title', 'content', 'author', 'category', 'tags', 'popularity'];
}
