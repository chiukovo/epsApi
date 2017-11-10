<?php

namespace App\Repositories;

use App\Models\CourseName;

class CourseNameRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        CourseName::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = CourseName::orderBy('term', 'desc')
            ->orderBy('term_type', 'desc')
            ->orderBy('Id', 'desc')
            ->orderBy('course_code', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
            }

            return $result;
        }
    }

    /**
     * get in course code
     *
     * @param array
     */
    public static function getInCourseCode($courseCode)
    {
        $data = CourseName::orderBy('term', 'desc')
            ->orderBy('term_type', 'desc')
            ->orderBy('Id', 'desc')
            ->whereIn('course_code', $courseCode)
            ->get();

        if ( ! is_null($data)) {
            return $data->toArray();
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            CourseName::where('Id', $id)->update($updateData);

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
            CourseName::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}