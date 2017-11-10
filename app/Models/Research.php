<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    //config guards name
    protected $table = 'Te_Result_Item_Data';

    public $timestamps = false;

    protected $guarded = [];
}