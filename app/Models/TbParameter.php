<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbParameter extends Model
{
    //config guards name
    protected $table = 'tbParameter';

    public $timestamps = false;

    protected $guarded = [];
}