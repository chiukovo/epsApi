<?php

namespace App\Repositories;

use App\Models\EvaluationItemsD4;
use Auth;

class EvaluationItemsD4Repositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        EvaluationItemsD4::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = EvaluationItemsD4::where($filters)->first();

        if ( ! is_null($data)) {
            return $data->toArray();
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            EvaluationItemsD4::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}