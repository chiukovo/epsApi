<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationItems extends Model
{
    //config guards name
    protected $table = 'Te_Evaluation_Items';

    public $timestamps = false;

    protected $guarded = [];
}