<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Introduction extends Model
{
    //config guards name
    protected $table = 'tbStu_Introduction';

    public $timestamps = false;

    protected $guarded = [];
}