<?php

namespace App\Repositories;

use App\Models\Read;
use Auth;

class ReadRepositories
{
    const FOLDER_NAME = 'read';

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Read::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Read::orderBy('Read_term', 'desc')
            ->orderBy('Read_term_type', 'desc')
            ->orderBy('Id', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['Read_photo']);
            }

            return $result;
        }
    }

    public static function getShareByFilters($filters, $search)
    {
        $data = Read::orderBy('Read_term', 'desc')
            ->orderBy('Read_term_type', 'desc')
            ->orderBy('Id', 'desc')
            ->where('Read_exp', '!=', '');

        if ( $search != '' ) {
            $data->where('Read_work', 'like', '%' . $search . '%' );
        } else {
            $data->where($filters);
        }

        $data = $data->get([
            'Read_work as title',
            'Read_term as term',
            'Read_term_type as term_type',
            'Read_exp as Deeds',
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
            Read::where('Id', $id)->update($updateData);

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
            Read::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}