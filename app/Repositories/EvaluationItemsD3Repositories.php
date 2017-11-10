<?php

namespace App\Repositories;

use App\Models\EvaluationItemsD3;
use Auth;

class EvaluationItemsD3Repositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        EvaluationItemsD3::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = EvaluationItemsD3::where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['radioType'] = '1';
                $result[$key]['needInsert'] = '';
                $result[$key]['fileData'] = '';
            }

            return $result;
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            EvaluationItemsD3::where('Id', $id)->update($updateData);

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
            EvaluationItemsD3::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }

    public static function deleteByItemsId($itemsId)
    {
        try {
            EvaluationItemsD3::where('Items_Id', $itemsId)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}