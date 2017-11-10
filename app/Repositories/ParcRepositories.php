<?php

namespace App\Repositories;

use App\Models\Parc;
use Auth;

class ParcRepositories
{
    const FOLDER_NAME = 'parc';

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Parc::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Parc::orderBy('parc_term', 'desc')
            ->orderBy('parc_term_type', 'desc')
            ->orderBy('Id', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['parc_photo']);
            }

            return $result;
        }
    }

    public static function getShareByFilters($filters, $search)
    {
        $data = Parc::orderBy('parc_term', 'desc')
            ->orderBy('parc_term_type', 'desc')
            ->orderBy('Id', 'desc');

        if ( $search != '' ) {
            $data->where('parc_exp', 'like', '%' . $search . '%' );
        } else {
            $data->where($filters);
        }

        $data = $data->get([
            'parc_work as title',
            'parc_term as term',
            'parc_term_type as term_type',
            'parc_exp as Deeds',
            'parc_photo',
        ]);

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['parc_photo']);

                if ( $info['Deeds'] == '' ) {
                    unset($result[$key]);
                }
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Parc::where('Id', $id)->update($updateData);

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
            Parc::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}