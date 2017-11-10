<?php

namespace App\Repositories;

use App\Models\ResearchField;

class ResearchFieldRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = ResearchField::orderBy('sort', 'asc')->where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $value) {
                $result[$key]['insertData'] = '';
            }

            return $result;
        }

        return [];
    }
}