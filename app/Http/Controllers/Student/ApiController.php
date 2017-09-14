<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\IntroductionRepositories;
use App\Repositories\ProfileWebRepositories;
use App\Repositories\EducationRepositories;
use App\Repositories\WorkexpRepositories;
use App\Repositories\StudyRepositories;
use App\Repositories\AbsentRepositories;
use App\Repositories\ServiceRepositories;
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
use Request;

class ApiController extends Controller
{
    /*
     * 個人簡歷
     */
    public function introduction()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            return [
                'status' => 'success',
                'data' => IntroductionRepositories::getByFilters(['Stu_Id' => $request['id']])
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * 學歷
     */
    public function education()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            return [
                'status' => 'success',
                'data' => EducationRepositories::getByFilters(['Stu_Id' => $request['id']])
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * 工作經驗
     */
    public function work()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            return [
                'status' => 'success',
                'data' => WorkexpRepositories::getByFilters(['Stu_Id' => $request['id']])
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * 個人網址
     */
    public function web()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            return [
                'status' => 'success',
                'data' => ProfileWebRepositories::getByFilters(['Stu_Id' => $request['id']])
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }
}
