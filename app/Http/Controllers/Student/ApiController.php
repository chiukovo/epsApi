<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\ActivityRepositories;
use App\Repositories\CommunityRepositories;
use App\Repositories\GadreRepositories;
use App\Repositories\LiceRepositories;
use App\Repositories\ParcRepositories;
use App\Repositories\ReadRepositories;
use App\Repositories\SchshipRepositories;
use App\Repositories\RandPRepositories;
use App\Repositories\RaceRepositories;
use App\Repositories\ExhiRepositories;
use App\Repositories\PerworksRepositories;
use App\Repositories\ShowRepositories;
use App\Repositories\AlbumRepositories;
use App\Repositories\AlbumNameRepositories;
use App\Repositories\ShareRepositories;
use App\Services\GalleryServices;
use App\Services\ShareServices;
use Request;

class ApiController extends Controller
{
    /*
     * 活動歷程
     */
    public function activity()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            $userId = $request['id'];

            return [
                'status' => 'success',
                'data' => [
                    'record' => ActivityRepositories::getByFilters(['Stu_Id' => $userId]),
                    'community' => CommunityRepositories::getByFilters(['Stu_Id' => $userId]),
                    'cadre' => GadreRepositories::getByFilters(['Stu_Id' => $userId]),
                ]
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * 職涯歷程
     */
    public function workCourse()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            $userId = $request['id'];

            return [
                'status' => 'success',
                'data' => [
                    'lice' => LiceRepositories::getByFilters(['Stu_Id' => $userId]),
                    'parcSchool' => epsStudentIntern($userId),
                    'parc' => ParcRepositories::getByFilters(['Stu_Id' => $userId]),
                    'read' => ReadRepositories::getByFilters(['Stu_Id' => $userId]),
                    'readSchool' => epsStudentWork($userId),
                ]
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * 榮譽記錄
     */
    public function honoraryRecord()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            $userId = $request['id'];

            return [
                'status' => 'success',
                'data' => [
                    'Schship' => SchshipRepositories::getByFilters(['Stu_Id' => $userId]),
                    'Race' => RaceRepositories::getByFilters(['Stu_Id' => $userId]),
                    'RandP' => epsStdHonor($userId),
                ]
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * 作品專區
     */
    public function workProject()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            $userId = $request['id'];

            return [
                'status' => 'success',
                'data' => [
                    'Perworks' => PerworksRepositories::getJoinAlbumByFilters(['tbStu_Perworks.Stu_Id' => $userId]),
                    'Exhi' => ExhiRepositories::getByFilters(['Stu_Id' => $userId]),
                    'Show' => ShowRepositories::getByFilters(['Stu_Id' => $userId]),
                ]
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * 照片資料
     */
    public function myGalleryDetail()
    {
        $request = Request::input();

        if ( authApiField($request) && isset($request['folderId']) ) {
            $userId = $request['id'];

            return [
                'status' => 'success',
                'data' => AlbumRepositories::getByFilters([
                    'tbStu_Album.Folder_Name_Id' => $request['folderId'],
                    'tbStu_Album.Stu_Id' => $userId,
                ]),
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * 個人相簿
     */
    public function myGallery()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            $userId = $request['id'];
            $pId = isset($request['folderId']) ? $request['folderId'] : 0;

            $gallery = AlbumNameRepositories::getJoinAlbumByFilters([
                'tbStu_Album_Name.Stu_Id' => getUserId(),
                'tbStu_Album_Name.P_Id' => $pId,
            ]);

            return [
                'status' => 'success',
                'data' => GalleryServices::getPidGroup($gallery)
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * 預警與輔導
     */
    public function earlyWarning()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            $userId = $request['id'];

            return [
                'status' => 'success',
                'data' => [
                    'scoreNotPass' => uspScoreSemsNotpass(getUserId()),
                    'record' => epsTeacherConsult(getUserId()),
                ]
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * 分享搜尋
     */
    public function shareSearch()
    {
        $request = Request::input();

        if ( authApiField($request) && isset($request['search']) ) {
            $userId = $request['id'];
            $searchType = isset($request['searchType']) ? $request['searchType'] : 1;

            return [
                'status' => 'success',
                'data' => ShareServices::getShareData($searchType, $userId, $request['search']),
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * my分享
     */
    public function myShare()
    {
        $request = Request::input();

        if ( authApiField($request)) {
            $userId = $request['id'];
            $selfType = isset($request['selfType']) ? $request['selfType'] : 1;

            return [
                'status' => 'success',
                'data' => ShareServices::getShareData($selfType, $userId),
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }
}
