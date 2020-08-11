<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        //Data
        $data = DB::table('issues')->count();
        $data2 = DB::table('issues')->where([
            ['issues.Statusid', 1],
            ['issues.Date_In', now()->toDateString()]
        ])->count();
        $data3 = DB::table('issues')->where('issues.Statusid', 3)->count();
        $data4 = DB::table('issues')->where('issues.Statusid', 2)->count();

        //Donut
        $datalabel = "'News','Defer','Closed'";
        $datatotal = "" . $data2 . "," . $data3 . "," . $data4 . "";

        //Column HW
        $databar = DB::table('issues_tracker')
            ->where([['TrackName', 'HW'], ['SubTrackName', 'Install'], ['Name', 'PC']])
            ->count();
        $databar2 = DB::table('issues_tracker')
            ->where([['TrackName', 'HW'], ['SubTrackName', 'Install'], ['Name', 'Printer']])
            ->count();
        $databar3 = DB::table('issues_tracker')
            ->where([['TrackName', 'HW'], ['SubTrackName', 'Fix'], ['Name', 'PC']])
            ->count();
        $databar4 = DB::table('issues_tracker')
            ->where([['TrackName', 'HW'], ['SubTrackName', 'Fix'], ['Name', 'Printer']])
            ->count();
        $databar5 = DB::table('issues_tracker')
            ->where([['TrackName', 'HW'], ['SubTrackName', 'Move'], ['Name', 'PC']])
            ->count();
        $databar6 = DB::table('issues_tracker')
            ->where([['TrackName', 'HW'], ['SubTrackName', 'Move'], ['Name', 'Printer']])
            ->count();
        $datattbar = "'Install'," . $databar . "," . $databar2 . "";
        $datattbar2 = "'Fix'," . $databar3 . "," . $databar4 . "";
        $datattbar3 = "'Move'," . $databar5 . "," . $databar6 . "";

        //Column SW
        $databarsw = DB::table('issues_tracker')
            ->where([['TrackName', 'SW'], ['SubTrackName', 'Install']])
            ->count();
        $databarsw2 = DB::table('issues_tracker')
            ->where([['TrackName', 'SW'], ['SubTrackName', 'Fix']])
            ->count();

        $datattbarsw = "'Install'," . $databarsw . "";
        $datattbarsw2 = "'Fix'," . $databarsw2 . "";

        //Bar Month
        $datamonthbar = DB::table('issues')->whereBetween('Date_In', ['2020-07-01','2020-07-31'])->count();
        $datatotalmonthbar = "" . $datamonthbar . ",11,20,30,40,50";

        return view('admin.dashboard', compact(
            ['data'],
            ['data2'],
            ['data3'],
            ['data4'],
            ['datalabel'],
            ['datatotal'],
            ['datatotalmonthbar'],
            ['datattbar'],
            ['datattbar2'],
            ['datattbar3'],
            ['datattbarsw'],
            ['datattbarsw2'],

        ));
    }
}
