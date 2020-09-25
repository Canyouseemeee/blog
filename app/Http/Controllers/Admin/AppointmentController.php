<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointments;
use Illuminate\Http\Request;

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
        $appointment->Uuid = $request->input('uuid');
        $Uuidapp = $appointment->Uuid;
        $appointment->save();

        return back()->with([['status','Appointment Added'],['Uuidapp']]);
    }
}
