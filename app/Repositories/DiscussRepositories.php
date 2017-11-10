<?php

namespace App\Repositories;

use App\Models\Discuss;
use Auth;

class DiscussRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Discuss::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Discuss::orderBy('Id', 'asc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['photo_path'] = getStudentPhotoUrl($info['std_no']);

                if ( ! is_null($info['teacher_id']) ) {
                    $result[$key]['teacher_photo_path'] = getTeacherPhotoUrl($info['teacher_id']);
                }

                $result[$key]['edit'] = false;
                $result[$key]['info'] = true;
            }

            return $result;
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            Discuss::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }

    public static function delete($id)
    {
        try {
            Discuss::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}