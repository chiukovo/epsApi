<?php

namespace App\Repositories;

use App\Models\Te_Expwork;
use Auth;

class TeacherExpworkRepositories
{
    public static function getConnectWhereIn($number)
    {
        $data = Te_Expwork::orderBy('Id', 'desc')
            ->whereIn('Number3', $number)
            ->get(['Number3', 'Work_name as title', 'Id']);

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
        $data = Te_Expwork::orderBy('Id', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
            }

            return formatListEvalName($result);
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Te_Expwork::where('id', $id)->update($updateData);

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
        Te_Expwork::create($insertData);

        return ['status' => 'success'];
    }

    public static function createReturnId($insertData)
    {
        return Te_Expwork::create($insertData)->id;
    }

    public static function delete($id)
    {
        try {
            Te_Expwork::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}