<?php

namespace App\Repositories;

use App\Models\Bulletin;
use Auth;

class BulletinRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Bulletin::orderBy('time', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }
}