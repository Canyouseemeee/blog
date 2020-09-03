<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issues;
use App\Models\MacAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
 
    public function Closed()
    {
        $demodata = DB::table('issues_tracker')
            ->select('issues.Issuesid', 'issues_tracker.TrackName','issues_tracker.SubTrackName','issues_tracker.Name',
            'ISSName', 'ISPName', 'issues.Users', 'issues.Subject','issues.Description','issues.created_at','issues.updated_at',
            'DmName','issues_logs.create_at')
            ->join('issues', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
            ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
            ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
            ->join('department', 'issues.Departmentid', '=', 'department.Departmentid')
            ->join('issues_logs', 'issues.Issuesid', '=', 'issues_logs.Issuesid')
            ->where([['issues.Statusid', 2],['Action','Closed']])
            ->orderBy('Issuesid', 'DESC')
            ->get();
        $issues = Issues::all();

        return response()->json($demodata);
    }

    public function New(){
        $demodata = DB::table('issues_tracker')
        ->select('Issuesid', 'issues_tracker.TrackName','issues_tracker.SubTrackName','issues_tracker.Name',
        'ISSName', 'ISPName', 'Users', 'issues.Subject','issues.Description','issues.created_at','issues.updated_at',
        'DmName')
        ->join('issues', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
        ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
        ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
        ->join('department', 'issues.Departmentid', '=', 'department.Departmentid')
        ->where('issues.Statusid', 1)
        ->orderBy('Issuesid', 'DESC')
        ->get();
        $issues = Issues::all();

        return response()->json($demodata);
    }

    public function Defer(){
        $demodata = DB::table('issues_tracker')
            ->select('Issuesid', 'issues_tracker.TrackName','issues_tracker.SubTrackName','issues_tracker.Name',
            'ISSName', 'ISPName', 'Users', 'issues.Subject','issues.Description','issues.created_at','issues.updated_at',
            'DmName')
            ->join('issues', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
            ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
            ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
            ->join('department', 'issues.Departmentid', '=', 'department.Departmentid')
            ->where('issues.Statusid', 3)
            ->orderBy('Issuesid', 'DESC')
            ->get();
        $issues = Issues::all();

        return response()->json($demodata);
    }


    public function postMacAddress(Request $request)
    {
        $_macAddress = $request->input('macAddress');

        // $MacAddress = new MacAddress();
        // $MacAddress->MacAddress = $_macAddress;
        // $MacAddress->save();

        return response()->json([
            'status' => 'Success',
            'input' => $_macAddress
        ]);
    }

    public function getMacAddress(){
        $dataMacAddress = MacAddress::all();

        return response()->json($dataMacAddress);
    }
}
