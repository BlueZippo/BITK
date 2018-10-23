<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['link', 'user_id', 'date'];

    protected $table = 'reminders';
    public $primaryKey = 'id';
    public $timestamps = true;
}
