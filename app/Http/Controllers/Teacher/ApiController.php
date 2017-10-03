<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repositories\TeacherIntroductionRepositories;
use Request;

class ApiController extends Controller
{
    /*
     * semsClass
     */
    public function semsClass()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            $userId = $request['id'];

            return [
                'status' => 'success',
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }
}
