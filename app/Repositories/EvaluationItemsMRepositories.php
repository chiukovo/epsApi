<?php

namespace App\Repositories;

use App\Models\EvaluationItemsM;
use Auth;

class EvaluationItemsMRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        EvaluationItemsM::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $loginInfo = getLoginInfo();
        $nowYear = getNowSems();

        $user = EvaluationItemsM::where($filters)->first();

        if ( ! is_null($user)) {
            return $user->toArray();
        } else {
            //沒有就新增一筆空值
            EvaluationItemsM::create([
                'Te_id' => $loginInfo['login_id'],
                'teacher_name' => $loginInfo['name'],
                'teacher_code' => $loginInfo['teacher_code'],
                'Date' => date('Y-m-d'),
                'teacher_title' => $loginInfo['teacher_title'],
                'college_name' => $loginInfo['college_name'],
                'dept_name' => $loginInfo['dept_name'],
                'term' => $nowYear['year'],
                'Self_check' => 0,
                'First_check' => 0,
                'Reviewer_check' => 0,
                'Decide_check' => 0,
                'loginInfo' => $loginInfo['depart_id'],
            ]);

            $user = EvaluationItemsM::where($filters)->first();

            return $user->toArray();
        }
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function checkByFilters($filters)
    {
        $data = EvaluationItemsM::where($filters)->first();

        if ( ! is_null($data)) {
            return $data->toArray();
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            EvaluationItemsM::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}