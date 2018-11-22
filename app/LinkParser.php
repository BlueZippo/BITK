<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkParser extends Model
{
    protected $fillable = ['domain', 'title', 'description', 'image'];

    protected $table = 'link_parsers';
    public $primaryKey = 'id';
    public $timestamps = true;
}
