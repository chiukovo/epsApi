<?php

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
    function uspCmRadar($std_no, $sems)
    {
        $db = DB::select(DB::raw("exec Academic.dbo.usp_cm_radar :sems, :ci_level, :cm_item_sno, :std_no"),[
            ':sems' => $sems,
            ':std_no' => $std_no,
            ':ci_level' => 'D',
            ':cm_item_sno' => 0,
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db[0];
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
    function uspScoreSemsNotpass()
    {
        $sems = getNowSems();

        $db = DB::select(DB::raw("exec Academic.dbo.usp_score_sems_notpass :rtype, :rname, :sems, :course_code, :info_date"),[
            ':rtype' => '',
            ':rname' => '',
            ':sems' => $sems['year'] . $sems['sems'],
            ':course_code' => '',
            ':info_date' => '',
        ]);

        $db = json_decode(json_encode($db), true);

        if ( ! empty($db)) {
            return $db;
        } else {
            return [];
        }
    }
}

if ( ! function_exists('epsTeacherConsult')) {
    /**
     * 會談記錄 eps_teacher_consult
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

if ( ! function_exists('getNowSems')) {
    /**
     * 取得歷年修課紀錄, 歷年請假缺曠紀錄, 服務學習 當今學年度
     *
     * @return array
     */
    function getNowSems()
    {
        $year = session('loginInfo')['course_map_year'];

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
        $db = DB::select(DB::raw("exec Academic.dbo.eps_teacher_data :sems, :teacher_code, :teacher_id"),[
            ':sems' => $sems,
            ':teacher_code' => $teacher_code,
            ':teacher_id' => 0,
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
        $db = DB::select(DB::raw("exec Academic.dbo.eps_teacher_course :sems, :teacher_code, :teacher_id"),[
            ':sems' => $sems,
            ':teacher_code' => 0,
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
    function spScorePrintSems($std_no)
    {
        $sems = getNowSems();

        $db = DB::select(DB::raw("exec Academic.dbo.sp_score_print_sems :sems, :dept_sno, :dept_group, :std_no"),[
            ':sems' => $sems['year'] . $sems['sems'],
            ':dept_sno' => 0,
            ':dept_group' => 0,
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