<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issuestracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TrackerController extends Controller
{
    public function index(){
        $issuestracker = Issuestracker::all();
        return view('admin.tracker.index',compact('issuestracker'));
    }

    public function create(){
        return view('admin.tracker.create');
    }

    public function store(Request $request){
        $issuestracker = new Issuestracker();
        $issuestracker->ISTName = $request->input('ISTName');
        $issuestracker->Description = $request->input('Description');
        $issuestracker->save();

        Session::flash('statuscode','success');
        return redirect('/tracker')->with('status','Data Added for Tracker Successfully');
    }

    public function edit($Trackerid){
        $issuestracker = Issuestracker::find($Trackerid);
        return view('admin.tracker.edit',compact('issuestracker'));
    }

    public function update(Request $request,$Trackerid){
        $issuestracker = Issuestracker::find($Trackerid);
        $issuestracker->ISTName = $request->input('ISTName');
        $issuestracker->Description = $request->input('Description');
        $issuestracker->update();

        Session::flash('statuscode','success');
        return redirect('/tracker')->with('status','Data Update for Tracker Successfully');
    }

    public function delete($Trackerid){
        $issuestracker = Issuestracker::findOrFail($Trackerid);
        $issuestracker->delete();
        return response()->json(['status'=>'Tracker Delete Sucessfully']);
    }
}
