<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\RegisterAuthRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("m", strtotime($strDate));
    $strDay = date("d", strtotime($strDate));
    $strHour = date("H", strtotime($strDate)) + 7;
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    return "$strDay-$strMonth-$strYear $strHour:$strMinute:$strSeconds";
}

class AuthController extends Controller
{

    public $loginAfterSignUp = true;

    public function login(Request $request){
        $input = $request->only('username','password');
        $username = $request->only('username');
        $jwt_token = null;
        $token = openssl_random_pseudo_bytes(20);
        $token2 = bin2hex($token);
        if(!$token = Auth::attempt($input)){
            return response()->json([
                'status' => 'Faild',
                'message' => 'Login Faild',
            ],401);
        }
        $expires_at = DateThai(now()->addHour(1));
        // if(!$token = JWTAuth::attempt($input)){
        //     return response()->json([
        //         'status' => 'Faild',
        //         'message' => 'Login Faild',
        //     ],401);
        // }

        return response()->json([
            'status' => 'Success',
            'token' => $token2,
            // 'token' => $jwt_token,
            'input' => $username,
            'expires_at' => $expires_at
        ]);
    }

    public function logout(Request $request) {
        $this->validate($request,[
            'token' => 'required'
        ]);

        try{
            Auth::invalidate($request->token);
            return response()->json([
                'status' => 'Success',
                'message' => 'Logout Success',
            ]);
        } catch(Exception $exception){
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

        $user = Auth::authenticate($request->token);
        return response()->json(['user' => $user]);
    }

    protected function jsonRespones($data,$code = 200){
        return response()->json($data,$code,[
            'Content-Type' => 'application/json;charset=UTF-8','Charset'=>'utf-8'
        ], JSON_UNESCAPED_UNICODE);
    }
}
