<?php

namespace App\Repositories;

use App\Models\Te_Room;
use Auth;

class TeacherRoomRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Te_Room::orderBy('Id', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Te_Room::where('id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Te_Room::create($insertData);

        return ['status' => 'success'];
    }

    public static function delete($id)
    {
        try {
            Te_Room::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}