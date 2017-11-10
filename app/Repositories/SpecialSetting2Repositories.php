<?php

namespace App\Repositories;

use App\Models\SpecialSetting2;
use Auth;

class SpecialSetting2Repositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        SpecialSetting2::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = SpecialSetting2::where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                if ( ! empty($info['Number']) ) {
                    $explode = explode(",", $info['Number']);
                    $result[$key]['Number'] = $explode;
                } else {
                    $result[$key]['Number'] = [];
                }
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            SpecialSetting2::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}