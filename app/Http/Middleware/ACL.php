<?php

namespace App\Http\Middleware;

use App\AccessModule;
use App\ItemModule;
use App\User;
use App\UserRole;
use Closure;
use Illuminate\Http\Response;

class ACL
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permission=$request->input('permission');
        $token=$request->header('token');
        $user_id=User::user_id($token);

        if (AccessModule::can($permission,$user_id))
            return $next($request);

        $params_output = [
            'message' => 'access denied!'
        ];
        return response()->json($params_output,Response::HTTP_UNAUTHORIZED);
    }
}
