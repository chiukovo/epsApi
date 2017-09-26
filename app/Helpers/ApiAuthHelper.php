<?php

if (! function_exists('authApiField')) {
    /**
     * auth api field
     * @return string
     */
    function authApiField($request)
    {
        if ( isset($request['id']) && isset($request['token'])) {
            $check = md5(env('APP_KEY') . $request['id']);

            if ( $check == $request['token'] ) {
                return true;
            }
        }

        return false;
    }
}