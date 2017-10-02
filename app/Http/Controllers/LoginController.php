<?php

namespace App\Http\Controllers;

use App\Services\UserAuthServices;
use Request;

class LoginController extends Controller
{
    /*
     * login
     */
    public function auth()
    {
        $userPost = Request::input();

        if ( authApiField($userPost) && isset($userPost['type']) && isset($userPost['password']) ) {
            return UserAuthServices::doLogin($userPost);
        }

        return [
            'status' => 'error',
            'message' => 'key auth fail or params not found'
        ];
    }
}
