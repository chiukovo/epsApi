<?php

namespace App\Repositories;

use App\Models\Lice;
use Auth;

class LiceRepositories
{

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Lice::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Lice::orderBy('Id', 'desc')
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
        $data = Lice::orderBy('Lice_date', 'desc')
            ->orderBy('Id', 'desc')
            ->where('Lice_exp', '!=', '');

        if ( $search != '' ) {
            $data->where('Lice_exp', 'like', '%' . $search . '%' );
        } else {
            $data->where($filters);
        }

        $data = $data->get([
            'Lice_name as title',
            'Lice_exp as Deeds',
        ]);

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['info'] = false;
                $result[$key]['term'] = '';
                $result[$key]['term_type'] = '';
                $result[$key]['photo_decode'] = '{"img_1":"","img_2":"","img_3":""}';
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Lice::where('Id', $id)->update($updateData);

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
            Lice::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}