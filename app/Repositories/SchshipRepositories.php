<?php

namespace App\Repositories;

use App\Models\Schship;
use Auth;

class SchshipRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Schship::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Schship::orderBy('Schship_term', 'desc')
            ->orderBy('Schship_term_type', 'desc')
            ->orderBy('Id', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
            }

            return $result;
        }
    }

    public static function getShareByFilters($filters, $search)
    {
        $data = Schship::orderBy('Schship_term', 'desc')
            ->orderBy('Schship_term_type', 'desc')
            ->orderBy('Id', 'desc')
            ->where('Schship_exp', '!=', '');

        if ( $search != '' ) {
            $data->where('Schship_name', 'like', '%' . $search . '%' );
        } else {
            $data->where($filters);
        }

        $data = $data->get([
            'Schship_name as title',
            'Schship_term as term',
            'Schship_term_type as term_type',
            'Schship_exp as Deeds',
        ]);

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = '{"img_1":"","img_2":"","img_3":""}';
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Schship::where('Id', $id)->update($updateData);

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
            Schship::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}