<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RoleController extends Controller
{
    public function registered(){
        $users = User::all();
        return view('admin.register',compact('users'));
    }

    public function registeredcreate(Request $request){
        
        return view('admin.register-create');
    }

    public function registerstore(Request $request)
    {
        $user = new User;
        $user->name = $request->input('name');
        $user->usertype = $request->input('usertype');
        $user->logintype = $request->input('logintype');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect('/role-register')->with('status','Your add user Success');
    }

    public function changActive(Request $request)
    {
        $user = User::find($request->id);
        $user->active = $request->active;
        echo($user->active);
        $user->save();
        return response()->json(['success' => 'Status Change successfully']);
    }

    public function registeredit(Request $request, $id){
        $users = User::findOrFail($id);
        return view('admin.register-edit',compact('users'));
    }

    public function registerupdate(Request $request, $id){
        $users = User::find($id);
        $users->name = $request->input('name');
        $users->usertype = $request->input('usertype');
        $users->logintype = $request->input('logintype');
        $users->username = $request->input('username');
        $users->update();

        return redirect('/role-register')->with('status','Your User is Updated');
    }

    public function registerreset(Request $request, $id){
        $users = User::findOrFail($id);
        return view('admin.register-reset',compact('users'));
    }

    public function registerresetpassword(Request $request, $id){
        $users = User::findOrFail($id);
        $users->password = Hash::make($request->input('password'));
        $users->update();
        return redirect('/role-register')->with('status','Your Password is Reset');
    }


}
