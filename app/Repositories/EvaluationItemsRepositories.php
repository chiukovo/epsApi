<?php

namespace App\Repositories;

use App\Models\EvaluationItems;
use Auth;

class EvaluationItemsRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        EvaluationItems::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = EvaluationItems::where($filters)->orderBy('Sort', 'asc')->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            return $result;
        }

        return [];
    }

    /**
     * get by filters group
     *
     * @param array
     */
    public static function getByFiltersGroup($filters, $group)
    {
        $data = EvaluationItems::where($filters)->orderBy('Sort', 'asc')->get();

        if ( ! is_null($data)) {
            $result = $data->groupBy($group)->toArray();

            return $result;
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            EvaluationItems::where('Id', $id)->orderBy('Sort', 'asc')->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}