<?php

namespace App\Repositories;

use App\Models\Review;
use Auth;

class ReviewRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getAll()
    {
        $data = Review::get();

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }
}