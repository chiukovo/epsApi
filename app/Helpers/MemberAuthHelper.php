<?php

if (! function_exists('getStudentPhotoUrl')) {
    /**
     * 左上角 小圖用 (登入帳號的大頭貼路徑)
     * @return string
     */
    function getStudentPhotoUrl($std_no = '')
    {
        $memberId = $std_no == '' ? getUserId() : $std_no;
        $time = date('YmdHi');
        //1 = auth member id 功能好了要改掉
        $imgPath = asset(env('UPLOAD_FOLDER_NAME') . '/' . $memberId . '/photo.jpg') . '?v=' . $time;

        $filePath = public_path(env('UPLOAD_FOLDER_NAME') . '/' . $memberId . '/photo.jpg');

        $imgUrl = (is_file($filePath)) ? $imgPath : asset('image/not-use/nouser.jpg');

        return $imgUrl;
    }
}

if (! function_exists('getTeacherPhotoUrl')) {
    /**
     * 左上角 小圖用 (登入帳號的大頭貼路徑)
     * @return string
     */
    function getTeacherPhotoUrl($teacherId)
    {
        $memberId = $teacherId == '' ? getUserId() : $teacherId;
        $time = date('YmdHi');
        //1 = auth member id 功能好了要改掉
        $imgPath = asset(env('UPLOAD_FOLDER_NAME') . '/' . $memberId . '/photo.jpg') . '?v=' . $time;
        $filePath = public_path(env('UPLOAD_FOLDER_NAME') . '/' . $memberId . '/photo.jpg');

        $imgUrl = (is_file($filePath)) ? $imgPath : asset('image/not-use/nouser.jpg');

        return $imgUrl;
    }
}

if (! function_exists('getUserId')) {
    /**
     * 左上角 小圖用 (登入帳號的大頭貼路徑)
     * @return string
     */
    function getUserId()
    {
        $request = Request::input();

        return $request['id'];
    }
}

if (! function_exists('getLoginInfo')) {
    /**
     * login info
     * @return array
     */
    function getLoginInfo()
    {
        return session('loginInfo');
    }
}