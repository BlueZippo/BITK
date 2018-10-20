<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkCategory extends Model
{
    public function link()
    {
      return $this->belongsTo('App\Link');
    }
}
