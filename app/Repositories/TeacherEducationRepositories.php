<?php

namespace App\Repositories;

use App\Models\Te_Education;
use Auth;

class TeacherEducationRepositories
{
    public static function getConnectWhereIn($number)
    {
        $data = Te_Education::orderBy('Id', 'desc')
            ->whereIn('Number3', $number)
            ->get(['Number3', 'Sch_name as title', 'Id']);

        if ( ! is_null($data)) {
            $result = $data->toArray();

            return $result;
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
        $data = Te_Education::orderBy('Education_type', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
            }

            return formatListEvalName($result);
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            Te_Education::where('id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }

    public static function create($insertData)
    {
        Te_Education::create($insertData);

        return ['status' => 'success'];
    }

    public static function createReturnId($insertData)
    {
        return Te_Education::create($insertData)->id;
    }

    public static function delete($id)
    {
        try {
            Te_Education::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}