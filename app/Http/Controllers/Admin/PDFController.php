<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issues;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function pdf(){
        $data =[];
        $Issues = Issues::all();
        $pdf = PDF::loadView('pdf',$data);
        return $pdf->stream('test.pdf');
    }
}
