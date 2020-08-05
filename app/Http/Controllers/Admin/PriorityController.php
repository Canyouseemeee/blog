<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issuespriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PriorityController extends Controller
{
    public function index(){
        $issuespriority = Issuespriority::all();
        return view('admin.priority.index',compact('issuespriority'));
    }

    public function create(){
        return view('admin.priority.create');
    }

    public function store(Request $request){
        $issuespriority = new Issuespriority();
        $issuespriority->ISPName = $request->input('ISPName');
        $issuespriority->Description = $request->input('Description');
        $issuespriority->save();

        Session::flash('statuscode','success');
        return redirect('/priority')->with('status','Data Added for Priority Successfully');
    }

    public function edit($Priorityid){
        $issuespriority = Issuespriority::find($Priorityid);
        return view('admin.priority.edit',compact('issuespriority'));
    }

    public function update(Request $request,$Priorityid){
        $issuespriority = Issuespriority::find($Priorityid);
        $issuespriority->ISPName = $request->input('ISPName');
        $issuespriority->Description = $request->input('Description');
        $issuespriority->update();

        Session::flash('statuscode','success');
        return redirect('/priority')->with('status','Data Update for Priority Successfully');
    }

    public function delete($Priorityid){
        $issuespriority = Issuespriority::findOrFail($Priorityid);
        $issuespriority->delete();
        return response()->json(['status'=>'Priority Delete Sucessfully']);
    }
}
