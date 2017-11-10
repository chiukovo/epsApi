<?php

namespace App\Repositories;

use App\Models\SpecialSetting3;
use Auth;

class SpecialSetting3Repositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        SpecialSetting3::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = SpecialSetting3::where($filters)->get();

        if ( ! is_null($data)) {
            return $data->toArray();
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            SpecialSetting3::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}