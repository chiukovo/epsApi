<?php

namespace App\Http\Middleware;

use Closure, Request;

class AuthWebLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $loginInfo = session('loginInfo');

        if ( ! isset($loginInfo) ) {
            return redirect('/');
        }

        //check type
        $type = $loginInfo['type'];

        if ( ! Request::is($type . '/*')) {
            return redirect('/' . $type . '/resume');
        }

        //teacher 不能使用

        return $next($request);
    }
}