<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repositories\TeacherIntroductionRepositories;
use App\Repositories\EvaluationItemsMRepositories;
use App\Repositories\EvaluationItemsD2Repositories;
use App\Repositories\SpecialSetting1Repositories;
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
            $sems = getNowSems('course_sems');
            $getSems = isset($request['sems']) ? $request['sems'] : $sems['year'] . $sems['sems'];
            $nowSems = $getSems;

            //teacher wip
            $teacher = getTeacherData($userId, $getSems);

            if ( empty($teacher)) {
                return [
                    'status' => 'error',
                    'message' => 'no data'
                ];
            }

            $class = epsTeacherCourse($teacher['teacher_id'], $userId, $nowSems);

            foreach ($class as $code => $info) {
                $students = epsRegicourse($nowSems, $code);

                foreach ($students as $key => $student) {
                    $std_no = $student['std_no'];
                    $studnetInfo = getStudentData($std_no, $nowSems);

                    if ( ! empty($studnetInfo) ) {
                        $students[$key]['std_name_c'] = $studnetInfo['std_name_c'];
                    }
                }

                $class[$code]['study_student'] = $students;
            }

            $class = array_values($class);

            return [
                'status' => 'success',
                'data' => $class,
            ];
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }

    /*
     * evaluation
     */
    public function evaluation()
    {
        $request = Request::input();

        if ( authApiField($request) ) {
            $userId = $request['id'];
            $sems = getNowSems();
            $teacher = getTeacherData($userId, $sems['year'] . $sems['sems']);

            //教師評鑑登打資料(字頭檔)
            $evaluation_M = EvaluationItemsMRepositories::getByFilters([
                'Te_id' => $teacher['teacher_id'],
                'term' => $sems['year'],
            ]);

            if ( ! empty($evaluation_M) ) {
                $D2 = EvaluationItemsD2Repositories::getByFilters([
                    'M_Id' => $evaluation_M['Id'],
                ]);

                return [
                    'status' => 'success',
                    'data' => $D2,
                ];
            }

            return [
                'status' => 'success',
                'data' => [],
            ];

        }

        return [
            'status' => 'error',
            'message' => 'key auth fail'
        ];
    }
}
