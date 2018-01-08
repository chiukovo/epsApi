<?php

namespace App\Services;

class UserAuthServices
{
    /**
     * do login
     *
     * @param array userPost
     * @return array
     */
    public static function doLogin($userPost)
    {
        $yearSems = getYearSems();
        $type = $userPost['type'];

        if ( $type == 'student' ) {
            $auth = studentAuth($userPost['id'], $userPost['password']);

            if ($auth == 'Y') {
                $student = getStudentData($userPost['id'], $yearSems['std_card_sems']);

                if ( empty($student) ) {
                    return [
                        'status' => 'error',
                        'msg' => '查無資料！請重新確認'
                    ];
                }

                return [
                    'status' => 'success',
                    'data' => [
                        'login_id' => $student['std_no'],
                        'name' => $student['std_name_c'],
                        'gschool_name' => $student['gschool_name'],
                        'gdept_name' => $student['gdept_name'],
                        'type' => $type,
                        'photo' => getStudentPhotoUrl($student['std_no'])
                    ],
                ];
            }
        } else {
            //teacher wip
            $teacher = getTeacherData($userPost['id'], $yearSems['std_card_sems']);

            if ( empty($teacher) ) {
                return [
                    'status' => 'error',
                    'msg' => '查無資料！請重新確認'
                ];
            }

            if ($teacher['teacher_pwd'] == '0x' . strtoupper(md5($userPost['password']))) {
                return [
                    'status' => 'success',
                    'data' => [
                        'login_id' => $teacher['teacher_id'],
                        'name' => $teacher['teacher_name'],
                        'college_name' => $teacher['college_name'],
                        'dept_name' => $teacher['dept_name'],
                        'type' => $type,
                        'photo' => getTeacherPhotoUrl($teacher['teacher_id'])
                    ],
                ];
            } else {
                return [
                    'status' => 'error',
                    'msg' => '密碼錯誤！請重新確認'
                ];
            }
        }

        return [
            'status' => 'error',
            'msg' => '帳號或密碼錯誤或身分錯誤！請重新確認'
        ];
    }
}