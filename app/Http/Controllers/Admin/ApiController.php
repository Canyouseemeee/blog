<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issues;
use App\Models\Loginlog;
use App\Models\MacAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("m", strtotime($strDate));
    $strDay = date("d", strtotime($strDate));
    $strHour = date("H", strtotime($strDate)) + 7;
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    return "$strYear-$strMonth-$strDay $strHour:$strMinute:$strSeconds";
}


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

    public function postlogin(Request $request)
    {
        $_username = $request->input('username');
        $_macaddress = $request->input('macaddress');
        $_ip = $request->input('ip');
        $_token = $request->input('token');

        $data = DB::table('users')
        ->select('id')
        ->where('username',$_username)
        ->get();

        $Loginlog = new Loginlog();
        $Loginlog->MacAddress = $_macaddress;
        $Loginlog->Userid = $data[0]->id;
        $Loginlog->Token = $_token;
        $Loginlog->Ip = $_ip;
        $Loginlog->expired = DateThai(now()->addMinutes(5));
        $Loginlog->created_at = DateThai(now());
        $Loginlog->updated_at = DateThai(now());
        $Loginlog->save();

        return response()->json([
            'status' => 'Success',
            'data' => $data,
            'macaddress' => $_macaddress,
            'ip' => $_ip,
            'token' => $_token
        ]);
    }

    public function delete(Request $request){
        $_token = $request->input('token');

        $data = DB::table('loginlog')
        ->select('Loginid')
        ->where([['Token',$_token],['expired','<',DateThai(now())]])
        ->get();
        // $Loginlog = Loginlog::findOrFail($data[0]->Loginid);
        // $Loginlog->delete();
        return response()->json([
            'action' => 'Delete',
            'status' => 'Success'
        ]);
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
