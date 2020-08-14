<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Issues;
use App\Models\Issuespriority;
use App\Models\Issuesstatus;
use App\Models\Issuestracker;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use PDF;

class PDFController extends Controller
{
    public function pdf($Issuesid){
        $Issues = Issues::find($Issuesid);
        $trackname = Issuestracker::all();
        $issuespriority = Issuespriority::all();
        $issuesstatus = Issuesstatus::all();
        $department = Department::all();
        $pdf = PDF::loadView('pdf',['Issues'=>$Issues,'trackname'=>$trackname
        ,'issuespriority'=>$issuespriority,'issuesstatus'=>$issuesstatus,'department'=>$department]);
        return $pdf->stream('Dataview.pdf');
    }
}
