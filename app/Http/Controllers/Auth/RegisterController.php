<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public $redirectTo = 'role-register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255','unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(array $data)
    {
        // User::create([
        //     'name' => $data['name'],
        //     'usertype' => $data['usertype'],
        //     'logintype' => $data['logintype'],
        //     'username' => $data['username'],
        //     'password' => Hash::make($data['password']),
        // ]);
        echo($data);

        $user = new User;
        $user->name = $data['name'];
        $user->usertype = $data['usertype'];
        $user->logintype = $data['logintype'];
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect('/issues');
    }

}
