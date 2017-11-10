<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discuss extends Model
{
    //config guards name
    protected $table = 'tbTe_discuss';

    public $timestamps = false;

    protected $guarded = [];
}