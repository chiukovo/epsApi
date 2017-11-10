<?php

namespace App\Repositories;

use App\Models\Research;

class ResearchRepositories
{
    public static function getConnectWhereIn($loginInfo, $number)
    {
        $data = Research::orderBy('Te_Result_Item_Data.Id', 'desc')
            ->where('Te_Result_Item_Data.username', $loginInfo['login_id'])
            ->where('Te_Result_Item_Data.dept_id', $loginInfo['depart_id'])
            ->whereIn('Te_Result_Item_Data.Number3', $number)
            ->join("Te_Result_Item as resultItem", function($join){
                $join->on("resultItem.sort", "=", "Te_Result_Item_Data.Item_Id")
                    ->on("resultItem.kind", "=", "Te_Result_Item_Data.Item_kind");
            })
            ->where('resultItem.YorN', 1)
            ->where('resultItem.dept_id', $loginInfo['depart_id'])
            ->get([
                'Te_Result_Item_Data.Item_contents as title',
                'Te_Result_Item_Data.Number3 as Number3',
                'Te_Result_Item_Data.Item_kind as kind',
                'Te_Result_Item_Data.Id as Id',
            ]);

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
        $data = Research::orderBy('Id', 'asc')->where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            return formatListEvalName($result);
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            Research::where('Id', $id)->update($updateData);

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
        Research::create($insertData);

        return ['status' => 'success'];
    }
    
    public static function createReturnId($insertData)
    {
        return Research::create($insertData)->id;
    }

    public static function deleteByFilters($filters)
    {
        try {
            Research::where($filters)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}