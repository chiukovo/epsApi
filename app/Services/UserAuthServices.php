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
                    'msg' => '',
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

            if ($teacher['teacher_pwd'] == '0x' . md5($userPost['password'])) {
                return [
                    'status' => 'success',
                    'msg' => '',
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