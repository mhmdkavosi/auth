<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Response;

class Auth
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
        $token=$request->header('token');
        if (User::checkUser($token))
            return $next($request);

        $params_output = [
            'message' => 'user Not found!Please check token.'
        ];
        return response()->json($params_output,Response::HTTP_UNAUTHORIZED);

    }
}
