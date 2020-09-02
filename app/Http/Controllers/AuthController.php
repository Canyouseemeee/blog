<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use App\Http\Requests\RegisterAuthRequest;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public $loginAfterSignUp = true;

    public function login(Request $request){
        $input = $request->only('username','password');
        $username = $request->only('username');
        $jwt_token = null;
        if(!$jwt_token = JWTAuth::attempt($input)){
            return response()->json([
                'status' => 'Faild',
                'message' => 'Login Faild',
            ],401);
        }

        return response()->json([
            'status' => 'Success',
            'token' => $jwt_token,
            'input' => $username
        ]);
    }

    public function logout(Request $request) {
        $this->validate($request,[
            'token' => 'required'
        ]);

        try{
            JWTAuth::invalidate($request->token);
            return response()->json([
                'status' => 'Success',
                'message' => 'Logout Success',
            ]);
        } catch(JWTException $exception){
            return response()->json([
                'status' => 'Error',
                'message' => 'Logout Error',
            ],500);
        }
    }

    public function getAuthUser(Request $request){
        $this->validate($request,[
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);
        return response()->json(['user' => $user]);
    }

    protected function jsonRespones($data,$code = 200){
        return response()->json($data,$code,[
            'Content-Type' => 'application/json;charset=UTF-8','Charset'=>'utf-8'
        ], JSON_UNESCAPED_UNICODE);
    }
}
