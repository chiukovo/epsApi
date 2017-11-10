<?php

namespace App\Repositories;

use App\Models\Exhi;
use Auth;

class ExhiRepositories
{
    const FOLDER_NAME = 'exhibition';

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Exhi::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Exhi::orderBy('Id', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['Exhi_photo']);
            }

            return $result;
        }
    }

    public static function getShareByFilters($filters, $search)
    {
        $data = Exhi::orderBy('Id', 'desc')
            ->where('Exhi_exp', '!=', '');

        if ( $search != '' ) {
            $data->where('Exhi_unit', 'like', '%' . $search . '%' );
        } else {
            $data->where($filters);
        }

        $data = $data->get([
            'Exhi_unit as title',
            'Exhi_exp as Deeds',
            'Exhi_photo',
        ]);

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['info'] = false;
                $result[$key]['term'] = '';
                $result[$key]['term_type'] = '';
                $result[$key]['photo_decode'] = json_decode($result[$key]['Exhi_photo']);
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Exhi::where('Id', $id)->update($updateData);

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
            Exhi::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}