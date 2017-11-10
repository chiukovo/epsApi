<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchField extends Model
{
    //config guards name
    protected $table = 'Te_Result_Item';

    public $timestamps = false;

    protected $guarded = [];
}