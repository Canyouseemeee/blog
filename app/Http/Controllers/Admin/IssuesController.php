<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Issues;
use App\Models\IssuesLogs;
use App\Models\Issuespriority;
use App\Models\Issuesstatus;
use App\Models\Issuestracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class IssuesController extends Controller
{
    public function index()
    {
        $issues = DB::table('issues_tracker')
            ->select('Issuesid', 'issues_tracker.TrackName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.updated_at')
            ->join('issues', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
            ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
            ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
            ->where([['issues.Statusid', 1], ['issues.Date_In', now()->toDateString()]])
            ->orderBy('Issuesid', 'DESC')
            ->get();
        $between = null;
        return view('admin.issues.index', compact(['issues'], ['between']));
    }

    public function getReport(Request $request)
    {
        $fromdate = $request->input('fromdate');
        $todate = $request->input('todate');
        if ($request->isMethod('post')) {
            $between = DB::table('issues_tracker')
                ->select('Issuesid', 'issues_tracker.TrackName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.updated_at')
                ->join('issues', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
                ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
                ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
                ->where('issues.Statusid', 1)
                ->whereBetween('issues.Date_In', [$fromdate, $todate])
                ->orderBy('Issuesid', 'DESC')
                ->get();
        } else {
            $between = null;
        }
        $issues = null;
        return view('admin.issues.index', compact(['issues'], ['between']));
    }

    public function defer()
    {
        $issues = DB::table('issues_tracker')
            ->select('Issuesid', 'issues_tracker.TrackName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.updated_at')
            ->join('issues', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
            ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
            ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
            ->where('issues.Statusid', 3)
            ->orderBy('Issuesid', 'DESC')
            ->get();
        $between = null;
        return view('admin.issues.defer', compact(['issues'], ['between']));
    }

    public function getReportdefers(Request $request)
    {
        $fromdate = $request->input('fromdate');
        $todate = $request->input('todate');
        if ($request->isMethod('post')) {
            $between = DB::table('issues_tracker')
                ->select('Issuesid', 'issues_tracker.TrackName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.updated_at')
                ->join('issues', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
                ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
                ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
                ->where('issues.Statusid', 3)
                ->whereBetween('issues.Date_In', [$fromdate, $todate])
                ->orderBy('Issuesid', 'DESC')
                ->get();
        } else {
            $between = null;
        }
        $issues = null;
        return view('admin.issues.defer', compact(['issues'], ['between']));
    }

    public function closed()
    {
        $issues = DB::table('issues_tracker')
            ->select('issues.Issuesid', 'issues_tracker.TrackName', 'ISSName', 'ISPName', 'issues.Users', 'Subject', 'issues_logs.create_at')
            ->join('issues', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
            ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
            ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
            ->join('issues_logs', 'issues_logs.Issuesid', '=', 'issues.Issuesid')
            ->where([['issues.Statusid', 2], ['Action', 'Closed']])
            ->orderBy('Issuesid', 'DESC')
            ->get();
        $between = null;
        return view('admin.issues.closed', compact(['issues'], ['between']));
    }

    public function getReportclosed(Request $request)
    {
        $fromdate = $request->input('fromdate');
        $todate = $request->input('todate');
        if ($request->isMethod('post')) {
            $between = DB::table('issues_tracker')
                ->select('Issuesid', 'issues_tracker.TrackName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.closed_at')
                ->join('issues', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
                ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
                ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
                ->where('issues.Statusid', 2)
                ->whereBetween('issues.Date_In', [$fromdate, $todate])
                ->orderBy('Issuesid', 'DESC')
                ->get();
        } else {
            $between = null;
        }
        $issues = null;
        return view('admin.issues.closed', compact(['issues'], ['between']));
    }

    public function create()
    {
        $tracker = DB::table('issues_tracker')
            ->groupBy('TrackName')
            ->get();
        $issues = Issues::all();
        // $issuestracker = Issuestracker::all();
        $issuespriority = Issuespriority::all();
        $issuesstatus = Issuesstatus::all();
        $department = DB::table('department')
            ->select('*')
            ->where('DmStatus', 1)
            ->get();
        return view('admin.issues.create', compact(
            ['issues'],
            ['issuespriority'],
            ['issuesstatus'],
            ['department'],
            ['tracker']
        ));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            array(
                'Trackerid' => 'required',
                'Subject' => 'required',
                'Description' => 'required',

            ),
            [
                'Trackerid.required' => 'You have select TrackName and SubTrackName and Name',
                'Subject.required' => 'You have enter Subject',
                'Description.required' => 'You have enter Description',
            ]
        );

        $issues = new Issues();
        $issues->Trackerid = $request->input('Trackerid');
        $issues->Priorityid = $request->input('Priorityid');
        $issues->Statusid = $request->input('Statusid');
        $issues->Departmentid = $request->input('Departmentid');
        $issues->Users = $request->input('Users');
        $issues->Subject = $request->input('Subject');
        $issues->Description = $request->input('Description');
        $issues->Date_In = $request->input('Date_In');

        if ($request->hasFile('Image')) {
            $filename = $request->Image->getClientOriginalName();
            $file = time() . '.' . $filename;
            $issues->Image = $request->Image->storeAs('images', $file, 'public');
            // dd($file);
        } else{
            $issues->Image = null;
        }


        // if ($request->file('Image')) {
        //     $file = $request->file('Image');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = time() . '.' . $extension;
        //     $file->move('uploads/issues/' . $filename);
        //     $issues->Image = $filename;
        // } else {
        //     return $request;
        //     $issues->Image = '';
        // }

        $issues->save();

        return redirect('/issues')->with('status', 'Data Added for Issues Successfully');
    }

    public function show($Issuesid)
    {
        $data = Issues::find($Issuesid);
        $tracker = Issuestracker::find($Issuesid);
        $issues = Issues::all();
        $trackname = Issuestracker::all();
        $issuespriority = Issuespriority::all();
        $issuesstatus = Issuesstatus::all();
        $department = Department::all();
        $issueslog = DB::table('issues_logs')
            ->select('issues_logs.create_at')
            ->join('issues', 'issues.Issuesid', '=', 'issues_logs.Issuesid')
            ->where([['Action', 'Closed'], ['issues_logs.Issuesid', $data->Issuesid]])
            ->get();
        return view('admin.issues.show', compact(
            ['issues'],
            ['issueslog'],
            ['data'],
            ['trackname'],
            ['issuespriority'],
            ['issuesstatus'],
            ['department'],
            ['tracker']
        ));
    }

    public function edit($Issuesid)
    {
        $data = Issues::find($Issuesid);
        $issues = Issues::all();
        $trackname = DB::table('issues_tracker')
            ->groupBy('TrackName')
            ->get();
        $find = DB::table('issues')
            ->select('issues_tracker.TrackName')
            ->join('issues_tracker', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
            ->where('issues_tracker.Trackerid', $data->Trackerid)
            ->groupBy('TrackName')
            ->get();
        $tracker = Issuestracker::all();
        $issuespriority = Issuespriority::all();
        $issuesstatus = Issuesstatus::all();
        $department = DB::table('department')
            ->select('*')
            ->where('DmStatus', 1)
            ->get();
        return view('admin.issues.edit', compact(
            ['issues'],
            ['data'],
            ['find'],
            ['trackname'],
            ['tracker'],
            ['issuespriority'],
            ['issuesstatus'],
            ['department']
        ));
    }

    public function update(Request $request, $Issuesid)
    {
        $this->validate(
            $request,
            array(
                'Trackerid' => 'required',
                'Subject' => 'required',
                'Description' => 'required',
                // 'Image' => 'required|image',

            ),
            [
                'Trackerid.required' => 'You have select TrackName and SubTrackName and Name',
                'Subject.required' => 'You have enter Subject',
                'Description.required' => 'You have enter Description',
            ]
        );

        $issues = Issues::find($Issuesid);
        $issues->Trackerid = $request->input('Trackerid');
        $issues->Priorityid = $request->input('Priorityid');
        if ($issues->Statusid == 2) {
            $issues->Statusid = $issues->Statusid;
        } else {
            $issues->Statusid = $request->input('Statusid');
        }
        $issues->Departmentid = $request->input('Departmentid');
        $issues->Users = $request->input('Users');
        $issues->Subject = $request->input('Subject');
        $issues->Description = $request->input('Description');
        $issues->Date_In = $request->input('Date_In');



        if ($request->hasFile('Image')) {
            $filename = $request->Image->getClientOriginalName();
            $file = time() . '.' . $filename;
            $issues->Image = $request->Image->storeAs('images', $file, 'public');
        } else {
            $issues->Image = $request->input('Image2');
        }

        $issues->update();

        return redirect('/issues')->with('status', 'Data Update for Issues Successfully');
    }

    public function fetch(Request $request)
    {
        $select = $request->get('select');
        $TrackName = $request->get('TrackName');
        $SubTrackName = $request->get('SubTrackName');
        $Name = $request->get('Name');
        $dependent = $request->get('dependent');
        // echo $select . "," . $value . "," . $dependent;
        $data = DB::table('issues_tracker')
            ->where($select, $TrackName)
            ->groupBy($dependent)
            ->get();
        $data2 = DB::table('issues_tracker')
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
    }


    public function findid(Request $request)
    {
        $TrackName = $request->get('TrackName');
        $SubTrackName = $request->get('SubTrackName');
        $Name = $request->get('Name');

        //it will get id if its id match with product id

        $p = Issuestracker::select('Trackerid')->where([['TrackName', $TrackName], ['SubTrackName', $SubTrackName], ['Name', $Name]])->first();
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

        if ($SubTrackName == 'Other') {
            $p2 = Issuestracker::select('Trackerid')->where([['TrackName', $TrackName], ['SubTrackName', 'Other']])->first();
            return $p2->Trackerid;
        }

        // echo $p;
        // $json = array("Trackerid" => $p->Trackerid);
        // echo print_r($json);
        // return response()->json($json);

    }

}
