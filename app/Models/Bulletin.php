<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    //config guards name
    protected $table = 'tbbulletin';

    public $timestamps = false;

    protected $guarded = [];
}