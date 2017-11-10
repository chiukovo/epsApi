<?php

namespace App\Repositories;

use App\Models\Expandrev;
use Auth;

class ExpandrevRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getBySemsCodeName($sems, $code, $name)
    {
        $filters = [
            'Stu_Id' => getUserId(),
            'sems' => $sems,
            'course_code' => $code,
            'course_name' => $name
        ];

        $data = Expandrev::orderBy('Id', 'desc')
            ->where($filters)
            ->first(['Id','Experience']);

        if ( ! is_null($data)) {
            return $data->toArray();
        } else {
            //沒有就新增一筆空值
            Expandrev::create($filters);

            $data = Expandrev::where($filters)->first(['Id', 'Experience']);

            return $data->toArray();
        }

        return [];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Expandrev::orderBy('Id', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            return $result;
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            Expandrev::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}