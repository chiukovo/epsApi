<?php

namespace App\Repositories;

use App\Models\Gadre;
use Auth;

class GadreRepositories
{
    const FOLDER_NAME = 'practice';

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Gadre::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Gadre::orderBy('Cadre_term', 'desc')
            ->orderBy('Cadre_term_type', 'desc')
            ->orderBy('Id', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['Cadre_photo']);
            }

            return $result;
        }
    }

    public static function getShareByFilters($filters, $search)
    {
        $data = Gadre::orderBy('Cadre_term', 'desc')
            ->orderBy('Cadre_term_type', 'desc')
            ->orderBy('Id', 'desc')
            ->where('Cadre_Deeds', '!=', '');

        if ( $search != '' ) {
            $data->where('Cadre_Deeds', 'like', '%' . $search . '%' );
        } else {
            $data->where($filters);
        }

        $data = $data->get([
            'Cadre_name as title',
            'Cadre_term as term',
            'Cadre_term_type as term_type',
            'Cadre_Deeds as Deeds',
            'Cadre_photo',
        ]);

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['Cadre_photo']);
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Gadre::where('Id', $id)->update($updateData);

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
            Gadre::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}