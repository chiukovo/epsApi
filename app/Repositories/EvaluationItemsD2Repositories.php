<?php

namespace App\Repositories;

use App\Models\EvaluationItemsD2;
use Auth;

class EvaluationItemsD2Repositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        EvaluationItemsD2::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = EvaluationItemsD2::where($filters)->get()->toArray();

        if ( ! empty($data)) {
            return $data;
        } else {
            $create = [
                'M_id' => $filters['M_id'],
                'Class' => $filters['Class'],
                'Name' => $filters['Name'],
            ];

            EvaluationItemsD2::create($create);
        }

        return [];
    }

    public static function updateByFilters($updateData, $filters)
    {
        try {
            EvaluationItemsD2::where($filters)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}