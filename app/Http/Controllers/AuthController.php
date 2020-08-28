<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;

    public function login(Request $request){
        $input = $request->only('email','password');
        $email = $request->only('email');
        $jwt_token = null;
        if(!$jwt_token = JWTAuth::attempt($input)){
            return response()->json([
                'status' => 'invalid_credentials',
                'message' => 'Login Faild',
            ],401);
        }

        return response()->json([
            'status' => 'OK',
            'token' => $jwt_token,
            'input' => $email
        ]);
    }

    public function logout(Request $request) {
        $this->validate($request,[
            'token' => 'required'
        ]);

        try{
            JWTAuth::invalidate($request->token);
            return response()->json([
                'status' => 'OK',
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
