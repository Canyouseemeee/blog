<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issuestracker;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TrackerController extends Controller
{
    public function index()
    {
        $trackname = Tracker::all();
        // ->get();
        return view('admin.tracker.index', compact('trackname'));
    }

    public function create()
    {
        $trackname = DB::table('tracker')
            ->groupBy('TrackName')
            ->get();
        return view('admin.tracker.create', compact('trackname'));
    }

    public function store(Request $request)
    {
        $dynamic = new Tracker();
        $dynamic->TrackName = $request->input('TrackName');
        $dynamic->SubTrackName = $request->input('SubTrackName');
        $dynamic->Name = $request->input('Name');
        $dynamic->save();

        Session::flash('statuscode', 'success');
        return redirect('/tracker')->with('status', 'Data Added for Tracker Successfully');
    }

    public function edit($Trackerid){
        $issuestracker = Tracker::find($Trackerid);
        return view('admin.tracker.edit',compact('issuestracker'));
    }

    public function update(Request $request,$Trackerid){
        $issuestracker = Tracker::find($Trackerid);
        $issuestracker->ISTName = $request->input('ISTName');
        $issuestracker->Description = $request->input('Description');
        $issuestracker->update();

        Session::flash('statuscode','success');
        return redirect('/tracker')->with('status','Data Update for Tracker Successfully');
    }

    public function delete($Trackerid){
        $issuestracker = Tracker::findOrFail($Trackerid);
        $issuestracker->delete();
        return response()->json(['status'=>'Tracker Delete Sucessfully']);
    }

    public function fetch(Request $request)
    {
        $select = $request->get('select');
        $TrackName = $request->get('TrackName');
        $SubTrackName = $request->get('SubTrackName');
        $Name = $request->get('Name');
        $dependent = $request->get('dependent');
        // echo $select . "," . $value . "," . $dependent;
        $data = DB::table('tracker')
            ->where($select, $TrackName)
            ->groupBy($dependent)
            ->get();
        $data2 = DB::table('tracker')
            ->where([['TrackName', $TrackName], [$select, $SubTrackName]])
            ->groupBy($dependent)
            ->get();
        $output = '<option value="" disabled="true" selected="true">Select '
            . ucfirst($dependent) . '</option>';

        //echo "DATA:".print_r($data);   

        foreach ($data as $row2) {
            $output = $output . '<option value="' . $row2->$dependent . '" > 
                ' . $row2->$dependent . ' </option>';
        }
        foreach ($data2 as $row3) {
            $output = $output . '<option value="' . $row3->$dependent . '"> 
                ' . $row3->$dependent . ' </option>';
        }
        echo $output;
        // echo $data;
        // return response()->json($data);
    }
}
