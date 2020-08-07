<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicTracker;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class DynamicController extends Controller
{
    public function index()
    {
        $trackname = DB::table('tracker')
            ->groupBy('TrackName')
            ->get();
        return view('admin.dynamic.dynamic', compact('trackname'));
    }

    public function index2()
    {
        $trackname = Tracker::all();
        // ->get();
        return view('admin.dynamic.index', compact('trackname'));
    }

    public function create()
    {
        $trackname = DB::table('tracker')
            ->groupBy('TrackName')
            ->get();
        return view('admin.dynamic.create', compact('trackname'));
    }

    public function store(Request $request)
    {
        $dynamic = new Tracker();
        $dynamic->TrackName = $request->input('TrackName');
        $dynamic->SubTrackName = $request->input('SubTrackName');
        $dynamic->Name = $request->input('Name');
        $dynamic->save();

        Session::flash('statuscode', 'success');
        return redirect('/dynamic')->with('status', 'Data Added for Tracker Successfully');
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


    public function findid(Request $request)
    {
        $TrackName = $request->get('TrackName');
        $SubTrackName = $request->get('SubTrackName');
        $Name = $request->get('Name');

        //it will get id if its id match with product id

        $p = DynamicTracker::select('Trackerid')->where([['TrackName', $TrackName], ['SubTrackName', $SubTrackName], ['Name', $Name]])->first();
        // echo $p;
        // $json = array("Trackerid" => $p->Trackerid);
        // echo print_r($json);
        // return response()->json($json);
        return $p->Trackerid;
    }

    public function findidother(Request $request)
    {
        $TrackName = $request->get('TrackName');
        $SubTrackName = $request->get('SubTrackName');
        $Name = $request->get('Name');

        //it will get id if its id match with product id

        if($SubTrackName == 'Other'){
            $p2 = DynamicTracker::select('Trackerid')->where([['TrackName', $TrackName], ['SubTrackName', 'Other']])->first();
            return $p2->Trackerid;
        }
        
        // echo $p;
        // $json = array("Trackerid" => $p->Trackerid);
        // echo print_r($json);
        // return response()->json($json);
        
    }
}
