<?php

namespace App\Repositories;

use App\Models\TbParameter;
use Auth;

class TbParameterRepositories
{
    /**
     * get only one
     *
     * @param array
     */
    public static function get()
    {
        $data = TbParameter::get()->first();

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }
}