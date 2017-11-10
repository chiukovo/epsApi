<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseName extends Model
{
    //config guards name
    protected $table = 'tbTe_Course_name';

    public $timestamps = false;

    protected $guarded = [];
}