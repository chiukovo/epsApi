<?php

namespace App\Repositories;

use App\Models\SpecialSetting1;
use Auth;

class SpecialSetting1Repositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        SpecialSetting1::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = SpecialSetting1::where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            SpecialSetting1::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}