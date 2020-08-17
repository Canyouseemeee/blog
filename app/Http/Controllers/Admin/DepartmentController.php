<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    public function index(){
        $department = Department::all();
        return view('admin.department.index',compact('department'));
    }

    public function create(){
        return view('admin.department.create');
    }

    public function store(Request $request){
        $this->validate($request, 
        array(
            'DmName' => 'required' ,
            'DmCode' => 'required' ,
            'Dm_Tel' => 'required|max:5'

        ),[
            'DmName.required' => 'You have enter Department Name',
            'DmCode.required' => 'You have enter Department CodeName',
            'Dm_Tel.required' => 'You have enter Department Tel'
        ]);

        $department = new Department();
        $department->DmName = $request->input('DmName');
        $department->Dm_Tel = $request->input('Dm_Tel');
        $department->save();

        Session::flash('statuscode','success');
        return redirect('/department')->with('status','Data Added for Department Successfully');
    }

    public function edit($Departmentid){
        $department = Department::find($Departmentid);
        return view('admin.department.edit',compact('department'));
    }

    public function update(Request $request,$Departmentid){
        $this->validate($request, 
        array(
            'DmName' => 'required' ,
            'DmCode' => 'required' ,
            'Dm_Tel' => 'required|max:5'

        ),[
            'DmName.required' => 'You have enter Department Name',
            'DmCode.required' => 'You have enter Department CodeName',
            'Dm_Tel.required' => 'You have enter Department Tel'
        ]);

        $department = Department::find($Departmentid);
        $department->DmName = $request->input('DmName');
        $department->Dm_Tel = $request->input('Dm_Tel');
        $department->update();

        Session::flash('statuscode','success');
        return redirect('/department')->with('status','Data Update for Department Successfully');
    }

    public function delete($Departmentid){
        $department = Department::findOrFail($Departmentid);
        $department->delete();
        Session::flash('statuscode','error');
        return redirect('/department')->with('danger','Your Data is Deleted');
    }
}
