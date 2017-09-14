<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //config guards name
    protected $table = 'tbReview';

    public $timestamps = false;

    protected $guarded = [];
}