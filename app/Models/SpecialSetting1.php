<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialSetting1 extends Model
{
    //config guards name
    protected $table = 'Te_Special_setting1';

    public $timestamps = false;

    protected $guarded = [];
}