<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request){
        $credentials = $request->only('email','password');
        $rules = [
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|max:30'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            $params_output = [
                'message' => $validator->errors()
            ];
            return response()->json($params_output,Response::HTTP_BAD_REQUEST);
        }
        $token=\Function_helper::makeToken();
        User::insert([
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
            'token'=>$token
        ]);
        $params_output = [
            'message' => 'register successfully!'
        ];
        return response()->json($params_output,Response::HTTP_CREATED);
    }

    public function getToken(Request $request){
        $credentials = $request->only('email','password');
        $rules = [
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:6|max:30'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            $params_output = [
                'message' => $validator->errors()
            ];
            return response()->json($params_output,Response::HTTP_BAD_REQUEST);
        }
        $user=User::select('email','password','token')
            ->where('email',$request->input('email'))
            ->first();
        if (empty($user))
        {
            $params_output = [
                'message' => 'user Not found!Please check email address.'
            ];
            return response()->json($params_output,Response::HTTP_BAD_REQUEST);
        }
        if (!Hash::check($request->input('password'),$user->password))
        {
            $params_output = [
                'message' => 'user Not found!Please check password.'
            ];
            return response()->json($params_output,Response::HTTP_BAD_REQUEST);
        }

        $params_output = [
            'message' => 'login successfully.',
            'data'=>
                [
                    'token'=>$user->token
                ]
        ];
        return response()->json($params_output,Response::HTTP_ACCEPTED);
    }
    public function refreshToken(Request $request){
        $credentials = $request->header();
        $rules = [
            'token'=>'required|exists:users,token',
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            $params_output = [
                'message' => $validator->errors()
            ];
            return response()->json($params_output,Response::HTTP_BAD_REQUEST);
        }
        $token=$request->header('token');
        $user=User::select('id','token')
            ->where('token',$token)
            ->first();
        if (empty($user))
        {
            $params_output = [
                'message' => 'user Not found!Please check token.'
            ];
            return response()->json($params_output,Response::HTTP_BAD_REQUEST);
        }
        $tokenRegenerated=User::updateToken($user->id);
        if (!$tokenRegenerated)
        {
            $params_output = [
                'message' => 'server Error.'
            ];
            return response()->json($params_output,Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $params_output = [
            'message' => 'token regenerated.'
        ];
        return response()->json($params_output,Response::HTTP_ACCEPTED);
    }
    public function test(){
        return 'test';
    }
}
