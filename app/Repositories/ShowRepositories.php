<?php

namespace App\Repositories;

use App\Models\Show;
use Auth;

class ShowRepositories
{
    const FOLDER_NAME = 'show';

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Show::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Show::orderBy('Id', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['Show_photo']);
            }

            return $result;
        }
    }

    public static function getShareByFilters($filters, $search)
    {
        $data = Show::orderBy('Id', 'desc')
            ->where('Show_exp', '!=', '');

        if ( $search != '' ) {
            $data->where('Show_unit', 'like', '%' . $search . '%' );
        } else {
            $data->where($filters);
        }

        $data = $data->get([
            'Show_unit as title',
            'Show_exp as Deeds',
            'Show_photo',
        ]);

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['info'] = false;
                $result[$key]['term'] = '';
                $result[$key]['term_type'] = '';
                $result[$key]['photo_decode'] = json_decode($result[$key]['Show_photo']);
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Show::where('Id', $id)->update($updateData);

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
            Show::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}