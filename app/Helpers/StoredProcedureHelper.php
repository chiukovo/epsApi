<?php

use App\Repositories\ExpandrevRepositories;

if (! function_exists('getYearSems')) {
    /**
     * @return array
     */
    function getYearSems()
    {
        $db = DB::select(DB::raw("exec Academic.dbo.eps_year_sems"));

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db[0];
        } else {
            return [];
        }
    }
}

if (! function_exists('getStudentData')) {
    /**
     * @return array
     */
    function getStudentData($std_no, $sems)
    {
        $db = DB::select(DB::raw("exec Academic.dbo.eps_student_data :sems, :dept_sno, :dept_group_sno, :std_no"),[
            ':sems' => $sems,
            ':dept_sno' => 0,
            ':dept_group_sno' => 0,
            ':std_no' => $std_no,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db[0];
        } else {
            return [];
        }
    }
}

if (! function_exists('studentAuth')) {
    /**
     * @return array
     */
    function studentAuth($std_no, $pwd)
    {
        $db = DB::select(DB::raw("exec Academic.dbo.eps_student_auth :std_no, :std_pwd"),[
            ':std_no' => $std_no,
            ':std_pwd' => '0x' . md5($pwd)
        ]);

        if ( ! empty($db)) {
            return $db[0]->rtn;
        } else {
            return 'N';
        }
    }
}

if (! function_exists('uspCmRadar')) {
    /**
     * 雷達圖 usp_cm_radar
     * @ci_level: D: 系級, C: 院級, S: 校級 (以核心能力查詢才需要校院系等級)
     *
     * @return array
     */
    function uspCmRadar($std_no, $level)
    {
        $sems = getNowSems('course_sems');

        $db = DB::select(DB::raw("exec Academic.dbo.usp_cm_radar :sems, :ci_level, :cm_item_sno, :std_no"),[
            ':sems' => $sems['year'] . $sems['sems'],
            ':std_no' => $std_no,
            ':ci_level' => $level,
            ':cm_item_sno' => 0,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}

if ( ! function_exists('uspScoreSemsNotpass')) {
    /**
     * 不及格 usp_score_sems_notpass
     *
     * @return array
     */
    function uspScoreSemsNotpass($std_no)
    {
        $result = [];
        $sems = getNowSems();

        //取得學期成績
        $score = spScorePrintSems($std_no);
        //成績不及格
        foreach ($score as $info) {
            $code = $info['course_code'];

            $db = DB::select(DB::raw("exec Academic.dbo.usp_score_sems_notpass :rtype, :rname, :sems, :course_code, :info_date"),[
                ':rtype' => 'N',
                ':rname' => '成績不及格',
                ':sems' => $sems['year'] . $sems['sems'],
                ':course_code' => $code,
                ':info_date' => '',
            ]);

            $db = json_decode(json_encode($db), true);

            if ( ! empty($db)) {
                $result = array_merge($result, $db);
            }
        }

        //type
        /*$type = [
            'C' => '操行不及格',
            'M' => '研究生0分',
            'TTC' => '三科不及格',
            'D' => '不及格科目之學分數達二分之一',
            'DD' => '二次二分之一不及格',
            'TD' => '三次二分之一不及格',
            'T' => '三分之二不及格',
            'B' => '一貫制主修不及格',
        ];

        foreach ($type as $rtype => $rname) {
            $db = DB::select(DB::raw("exec Academic.dbo.usp_score_sems_notpass :rtype, :rname, :sems, :course_code, :info_date"),[
                ':rtype' => $rtype,
                ':rname' => $rname,
                ':sems' => $sems['year'] . $sems['sems'],
                ':course_code' => '',
                ':info_date' => '',
            ]);

            $db = json_decode(json_encode($db), true);

            if ( ! empty($db)) {
                $result = array_merge($result, $db);
            }
        }*/

        $studentNotPass = [];
        foreach ($result as $info) {
            if ( $info['std_no'] == $std_no ) {
                $studentNotPass[] = $info;
            }
        }

        return $studentNotPass;
    }
}

if ( ! function_exists('epsTeacherConsult')) {
    /**
     * 會談記錄(學生) eps_teacher_consult
     *
     * @return array
     */
    function epsTeacherConsult($std_no)
    {
        $sems = getNowSems();

        $db = DB::select(DB::raw("exec Academic.dbo.eps_teacher_consult :sems, :teacher_id, :std_no"),[
            ':sems' => $sems['year'] . $sems['sems'],
            ':teacher_id' => '',
            ':std_no' => $std_no,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}


if ( ! function_exists('epsTeacherConsultByTeacher')) {
    /**
     * 會談記錄(老師) eps_teacher_consult
     *
     * @return array
     */
    function epsTeacherConsultByTeacher($loginId, $sems)
    {
        $db = DB::select(DB::raw("exec Academic.dbo.eps_teacher_consult :sems, :teacher_id, :std_no"),[
            ':sems' => $sems,
            ':teacher_id' => $loginId,
            ':std_no' => '',
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}

if ( ! function_exists('getNowSems')) {
    /**
     * 取得歷年修課紀錄, 歷年請假缺曠紀錄, 服務學習 當今學年度
     *
     * @return array
     */
    function getNowSems($target = 'std_card_sems')
    {
        $year = getYearSems()[$target];

        return [
            'year' => substr($year, 0, -1),
            'sems' => substr($year, '-1'),
        ];
    }
}

if (! function_exists('getTeacherData')) {
    /**
     * @return array
     */
    function getTeacherData($teacher_code, $sems)
    {
        $db = DB::select(DB::raw("exec Academic.dbo.eps_teacher_data :sems, :teacher_code"),[
            ':sems' => $sems,
            ':teacher_code' => $teacher_code,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db[0];
        } else {
            return [];
        }
    }
}

if (! function_exists('epsTeacherCourse')) {
    /**
     * @return array
     */
    function epsTeacherCourse($teacher_id, $sems)
    {
        $db = DB::select(DB::raw("exec Academic.dbo.eps_teacher_course :sems, :teacher_id"), [
            ':sems' => $sems,
            ':teacher_id' => $teacher_id,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            $format = [];

            foreach ($db as $info) {
                $format[$info['course_code']] = $info;
            }

            return $format;
        } else {
            return [];
        }
    }
}

if (! function_exists('spScorePrintSems')) {
    /**
     * 學生所選的課
     *
     * @return array
     */
    function spScorePrintSems($std_no, $sems = '')
    {
        if ( $sems == '' ) {
            $sems = getNowSems();
            $sems = $sems['year'] . $sems['sems'];
        }

        DB::update(DB::raw("exec Academic.dbo.sp_score_print_sems :sems, :dept_sno, :dept_group_sno, :std_no"),[
            ':sems' => $sems,
            ':dept_sno' => 0,
            ':dept_group_sno' => 0,
            ':std_no' => $std_no,
        ]);

		$db = DB::table('Academic.dbo.tblscore_print_sems')
	        ->where('std_no', $std_no)
	        ->get();

	    $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {

            $db = collect($db)->map(function ($info) {
                if ( $info['course_credit'] == '.0') {
                    $info['course_credit'] = '0.0';
                }
                if ( $info['score'] == '.0') {
                    $info['score'] = '0.0';
                }
                return $info;
            })->toArray();

            return $db;
        } else {
            return [];
        }
    }
}

if (! function_exists('spStdAbsence')) {
    /**
     * 可得到總缺課
     *
     * @return array
     */
    function spStdAbsence($std_no, $sems = '')
    {
        if ( $sems == '' ) {
            $sems = getNowSems();
            $sems = $sems['year'] . $sems['sems'];
        }

        ini_set('default_charset', 'Big5');

        $db = DB::select(DB::raw("exec Academic.dbo.sp_std_absence :sems, :std_no"),[
            ':sems' => $sems,
            ':std_no' => $std_no,
        ]);

        foreach ($db as $key => $info) {
            $format = [];
            $info = (array) $info;

            foreach ($info as $dtKey => $dtInfo) {
                $dtKey = mb_convert_encoding($dtKey, "UTF-8", "BIG5");

                if ( $dtKey == '總缺課(含不列計缺課)' ) {
                    $dtKey = '總缺課';
                }
                $format[$dtKey] = $dtInfo;
            }

            $db[$key] = $format;
        }

        ini_set('default_charset', 'UTF-8');

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}

if (! function_exists('epsCourseSems')) {
    /**
     * 會得到課程名稱，上課時數，上課地點
     *
     * @return array
     */
    function epsCourseSems()
    {
        $sems = getNowSems();

        $db = DB::select(DB::raw("exec Academic.dbo.eps_course_sems :sems, :dept_sno, :dept_group_sno"),[
            ':sems' => $sems['year'] . $sems['sems'],
            ':dept_sno' => 0,
            ':dept_group_sno' => 0,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}

if (! function_exists('getExpAndReview')) {
    /**
     * 心得與檢討data
     *
     * @return array
     */
    function getExpAndReview($userId)
    {
        $sems = getNowSems();
        //可得到總缺課
        $missClass = spStdAbsence($userId);
        //可得到 學期、課程名稱、學分數、成績
        $class = spScorePrintSems($userId);

        foreach ($class as $classKey => $info) {
            $semsAll = $sems['year'] . $sems['sems'];
            $class[$classKey]['missClass'] = '';
            $class[$classKey]['sems'] = $semsAll;
            $class[$classKey]['info'] = false;
            $class[$classKey]['edit'] = false;

            //取得檢討
            $rev = ExpandrevRepositories::getBySemsCodeName($semsAll, $info['course_code'], $info['course_name']);
            $class[$classKey]['Id'] = $rev['Id'];
            $class[$classKey]['Experience'] = $rev['Experience'];

            foreach ($missClass as $miss) {
                //中文key值 =_=b...
                if ( isset($miss['課程代碼']) ) {
                    if ( $info['course_code'] == $miss['課程代碼']) {
                        $class[$classKey]['missClass'] = $miss['總缺課'];
                    }
                }
            }
        }

        return $class;
    }
}

if (! function_exists('epsStudentIntern')) {
    /**
     * 實習經驗
     *
     * @return array
     */
    function epsStudentIntern($std_no)
    {
        $sems = getNowSems();

        $db = DB::select(DB::raw("exec Academic.dbo.eps_student_intern :sems, :std_no"),[
            ':sems' => $sems['year'] . $sems['sems'],
            ':std_no' => $std_no,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}

if (! function_exists('epsStudentWork')) {
    /**
     * 實習經驗
     *
     * @return array
     */
    function epsStudentWork($std_no)
    {
        $sems = getNowSems();

        $db = DB::select(DB::raw("exec Academic.dbo.eps_student_work :sems, :std_no"),[
            ':sems' => $sems['year'] . $sems['sems'],
            ':std_no' => $std_no,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}

if (! function_exists('epsStdHonor')) {
    /**
     * 獎懲紀錄
     *
     * @return array
     */
    function epsStdHonor($std_no)
    {
        $sems = getNowSems();

        $db = DB::select(DB::raw("exec Academic.dbo.eps_std_honor :sems, :std_no"),[
            ':sems' => $sems['year'] . $sems['sems'],
            ':std_no' => $std_no,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}

if (! function_exists('epStdServiceCourse')) {
    /**
     * 服務學習
     *
     * @return array
     */
    function epStdServiceCourse($std_no)
    {
        $sems = getNowSems();

        $db = DB::select(DB::raw("exec Academic.dbo.eps_std_service_course :sems, :std_no"),[
            ':sems' => $sems['year'] . $sems['sems'],
            ':std_no' => $std_no,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}

if (! function_exists('epsTeacherDirector')) {
    /**
     * 服務學習
     *
     * @return array
     */
    function epsTeacherDirector($teacher_id, $sems)
    {
        $db = DB::select(DB::raw("exec Academic.dbo.eps_teacher_director :sems, :teacher_id"),[
            ':sems' => $sems,
            ':teacher_id' => $teacher_id,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}

if (! function_exists('epsTeacherEvent')) {
    /**
     * 服務學習
     *
     * @return array
     */
    function epsTeacherEvent($teacher_id, $sems)
    {
        $db = DB::select(DB::raw("exec Academic.dbo.eps_teacher_event :sems, :teacher_id"),[
            ':sems' => $sems,
            ':teacher_id' => $teacher_id,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            foreach ($db as $key => $info) {
                $db[$key]['info'] = false;
            }

            return $db;
        } else {
            return [];
        }
    }
}

if (! function_exists('epsRegicourse')) {
    /**
     * 學生修課
     *
     * @return array
     */
    function epsRegicourse($sems, $course_code)
    {
        $db = DB::select(DB::raw("exec Academic.dbo.eps_regicourse :sems, :course_code"),[
            ':sems' => $sems,
            ':course_code' => $course_code,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}