<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{
    public function index()
    {
        $data = DB::table('issues')->count();
        $data2 = DB::table('issues')->where([['issues.Statusid', 1], 
        ['issues.Date_In', now()->toDateString()]])->count();
        $data3 = DB::table('issues')->where('issues.Statusid', 3)->count();
        $data4 = DB::table('issues')->where('issues.Statusid', 2)->count();
        $datalabel = "'aaa','bbb','ccc'";
        $datatotal = "".$data3.",".$data4.",88";

        return view('admin.dashboard', compact(['data'],['data2'],['data3'],['data4'],['datalabel'],['datatotal']));
    }
}
