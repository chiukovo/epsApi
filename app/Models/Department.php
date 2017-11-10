<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //config guards name
    protected $table = 'tbDepartment';

    public $timestamps = false;

    protected $guarded = [];
}