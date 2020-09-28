<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class AppointmentController extends Controller
{
    public function store(Request $request){
        $appointment = new Appointments();
        $appointment->Issuesid = 0;
        $appointment->Date = $request->input('AppointDate');
        $appointment->Comment = $request->input('Comment');
        $appointment->Status = $request->input('Status');
        $appointment->Createby = $request->input('Createby');
        $appointment->Updateby = $request->input('Createby');
        $Uuidapp = Str::uuid()->toString();
        $appointment->Uuid = $Uuidapp;
        $appointment->save();

        return back()->with([$Uuidapp,'Uuidapp']);
    }

    public function genissues(){
        return Route::get(['IssuesController@create' => 'Uuidapp']);
    }
}
