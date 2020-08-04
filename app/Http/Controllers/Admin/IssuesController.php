<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Issues;
use App\Models\Issuespriority;
use App\Models\Issuesstatus;
use App\Models\Issuestracker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssuesController extends Controller
{
    public function index()
    {
        $issues = DB::table('issues_tracker')
            ->select('Issuesid', 'ISTName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.updated_at')
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
                ->select('Issuesid', 'ISTName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.updated_at')
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
            ->select('Issuesid', 'ISTName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.updated_at')
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
                ->select('Issuesid', 'ISTName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.updated_at')
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
            ->select('Issuesid', 'ISTName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.updated_at')
            ->join('issues', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
            ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
            ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
            ->where('issues.Statusid', 2)
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
                ->select('Issuesid', 'ISTName', 'ISSName', 'ISPName', 'Users', 'Subject', 'issues.updated_at')
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
        $issues = Issues::all();
        $issuestracker = Issuestracker::all();
        $issuespriority = Issuespriority::all();
        $issuesstatus = Issuesstatus::all();
        $department = Department::all();
        return view('admin.issues.create', compact(
            ['issues'],
            ['issuestracker'],
            ['issuespriority'],
            ['issuesstatus'],
            ['department']
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Subject' => 'required',
            'Description' => 'required',
            'Image' => 'required|image|max:2048'
        ]);

        $issues = new Issues();
        $issues->Trackerid = $request->input('Trackerid');
        $issues->Priorityid = $request->input('Priorityid');
        $issues->Statusid = $request->input('Statusid');
        $issues->Departmentid = $request->input('Departmentid');
        $issues->Users = $request->input('Users');
        $issues->Subject = $request->input('Subject');
        $issues->Description = $request->input('Description');
        $issues->Date_In = $request->input('Date_In');


        if ($request->file('Image')) {
            $file = $request->file('Image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/issues/' . $filename);
            $issues->Image = $filename;
        } else {
            return $request;
            $issues->Image = '';
        }

        $issues->save();

        return redirect('/issues')->with('status', 'Data Added for Issues Successfully');
    }

    public function show($Issuesid)
    {
        $data = Issues::find($Issuesid);
        $issues = Issues::all();
        $issuestracker = Issuestracker::all();
        $issuespriority = Issuespriority::all();
        $issuesstatus = Issuesstatus::all();
        $department = Department::all();
        return view('admin.issues.show', compact(
            ['issues'],
            ['data'],
            ['issuestracker'],
            ['issuespriority'],
            ['issuesstatus'],
            ['department']
        ));
    }

    public function edit($Issuesid)
    {
        $data = Issues::find($Issuesid);
        $issues = Issues::all();
        $issuestracker = Issuestracker::all();
        $issuespriority = Issuespriority::all();
        $issuesstatus = Issuesstatus::all();
        $department = Department::all();
        return view('admin.issues.edit', compact(
            ['issues'],
            ['data'],
            ['issuestracker'],
            ['issuespriority'],
            ['issuesstatus'],
            ['department']
        ));
    }

    public function update(Request $request, $Issuesid)
    {
        $issues = Issues::find($Issuesid);
        $issues->Trackerid = $request->input('Trackerid');
        $issues->Priorityid = $request->input('Priorityid');
        $issues->Statusid = $request->input('Statusid');
        $issues->Departmentid = $request->input('Departmentid');
        $issues->Users = $request->input('Users');
        $issues->Subject = $request->input('Subject');
        $issues->Description = $request->input('Description');
        $issues->Date_In = $request->input('Date_In');

        if ($request->file('Image')) {
            $file = $request->file('Image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/issues/' . $filename);
            $issues->Image = $filename;
        } else {
            return $request;
            $issues->Image = '';
        }

        $issues->update();

        return redirect('/issues')->with('status', 'Data Update for Issues Successfully');
    }
}
