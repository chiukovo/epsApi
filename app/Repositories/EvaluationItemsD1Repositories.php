<?php

namespace App\Repositories;

use App\Models\EvaluationItemsD1;
use Auth;

class EvaluationItemsD1Repositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        EvaluationItemsD1::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = EvaluationItemsD1::where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            return $result;
        }
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function createForSelect($mId, $number)
    {
        $filters = [
            'M_id' => $mId,
            'Number' => $number,
        ];

        $data = EvaluationItemsD1::where($filters)->first();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            return $result;
        } else {
            //沒有就新增一筆空值
            EvaluationItemsD1::create([
                'M_id' => $mId,
                'Number' => $number,
            ]);

            $user = EvaluationItemsD1::where($filters)->first();

            return $user->toArray();
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            EvaluationItemsD1::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}