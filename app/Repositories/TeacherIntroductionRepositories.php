<?php

namespace App\Repositories;

use App\Models\Te_Introduction;
use Auth;

class TeacherIntroductionRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Te_Introduction::where($filters)->first();
        $userInfo = getLoginInfo();

        if ( ! is_null($data)) {
            return $data->toArray();
        } else {
            $nowYear = getNowSems();

            //沒有就新增一筆空值
            Te_Introduction::create([
                'Te_Id' => getUserId(),
                'teacher_code' => $userInfo['teacher_code'],
                'teacher_name' => $userInfo['name'],
                'dept_name' => $userInfo['dept_name'],
                'term' => $nowYear['year'] . $nowYear['sems'],
            ]);

            $data = Te_Introduction::where($filters)->first(['Introduction']);

            return $data->toArray();
        }
    }

    public static function updateByTeId($updateData, $id)
    {
        try {
            Te_Introduction::where('Te_Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}