<?php

namespace App\Repositories;

use App\Models\Department;
use Auth;

class DepartmentRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Department::orderBy('Id', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }

    /**
     * get by search
     *
     * @param array
     */
    public static function searchDepartId($departName)
    {
        $data = Department::orderBy('Id', 'desc')
            ->where('Depart_name', 'like', '%' . $departName . '%')
            ->get()
            ->first();

        if ( ! is_null($data)) {
            return $data->toArray();
        }

        return [];
    }
}