<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssuesComment;
use Illuminate\Http\Request;

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate)) + 7;
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    return "$strDay-$strMonth-$strYear $strHour:$strMinute:$strSeconds";
}

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate(
            $request,
            array(
                'CComment' => 'required',
            ),
        );

        $comment = new IssuesComment();
        $comment->Issuesid = 0;
        $comment->Type = 0;
        $comment->Status = 1;
        $comment->Comment = $request->input('CComment');
        $comment->Uuid = $request->input('Ctemp');
        $comment->Createby = $request->input('CCreateby');
        $comment->Updateby = $request->input('CCreateby');
        $comment->created_at = DateThai(now());
        $comment->updated_at = DateThai(now());

        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $file = time() . '.' . $filename;
            $comment->Image = $request->image->storeAs('images', $file, 'public');
            // dd($file);
        } else {
            $comment->Image = null;
        }
        $comment->save();

    }

    // public function update(Request $request)
    // {
    //     $this->validate(
    //         $request,
    //         array(
    //             'AppointDate' => 'required',
    //             'Comment' => 'required',
    //         ),
    //     );
    //     $Uuid = $request->input('Uuid');
    //     $Appoint =  DB::table('appointments')
    //         ->select('Appointmentsid')
    //         ->where('Uuid', $Uuid)
    //         ->get();
    //     foreach ($Appoint as $row) {
    //         $Appointmentsid = $row->Appointmentsid;
    //     }
    //     // echo($Uuid);
    //     $appointment = Appointments::find($Appointmentsid);
    //     $appointment->Issuesid = 0;
    //     $appointment->Date = $request->input('AppointDate');
    //     $appointment->Comment = $request->input('Comment');
    //     $appointment->Status = $request->input('Status');
    //     $appointment->Updateby = $request->input('Updateby');
    //     $appointment->Uuid = $request->input('Uuid');
    //     $appointment->updated_at = DateThai(now());
    //     $appointment->update();

    //     // return back();
    // }

    // public function storeedit(Request $request)
    // {
    //     $this->validate(
    //         $request,
    //         array(
    //             'AppointDate' => 'required',
    //             'Comment' => 'required',
    //         ),
    //     );
    //     $count = DB::table('appointments')
    //         ->select('Appointmentsid')
    //         ->where('Uuid', $request->input('temp'))
    //         ->count();
    //     // echo($count);
    //     if ($count >= 1) {
    //         $data = DB::table('appointments')
    //             ->select('Appointmentsid')
    //             ->where('Uuid', $request->input('temp'))
    //             ->max('Appointmentsid');
    //         $appoint = Appointments::find($data);
    //         $appoint->Status = 2;
    //         $appoint->update();
    //     }
    //     $appointment = new Appointments();
    //     $appointment->Issuesid = $request->input('Issuesid');
    //     $appointment->Date = $request->input('AppointDate');
    //     $appointment->Comment = $request->input('Comment');
    //     $appointment->Status = $request->input('Status');
    //     $appointment->Createby = $request->input('Createby');
    //     $appointment->Updateby = $request->input('Createby');
    //     $appointment->Uuid = $request->input('temp');
    //     $appointment->created_at = DateThai(now());
    //     $appointment->updated_at = DateThai(now());
    //     $appointment->save();

        
    //     return response()->json();
    // }

    // public function updateedit(Request $request)
    // {
    //     $this->validate(
    //         $request,
    //         array(
    //             'AppointDate' => 'required',
    //             'Comment' => 'required',
    //         ),
    //     );
    //     $Uuid = $request->input('Uuid');
    //     $Appoint =  DB::table('appointments')
    //         ->select('Appointmentsid')
    //         ->where('Uuid', $Uuid)
    //         ->get();
    //     foreach ($Appoint as $row) {
    //         $Appointmentsid = $row->Appointmentsid;
    //     }
    //     $appointment = Appointments::find($Appointmentsid);
    //     $appointment->Issuesid = $request->input('Issuesid');
    //     $appointment->Date = $request->input('AppointDate');
    //     $appointment->Comment = $request->input('Comment');
    //     $appointment->Status = $request->input('Status');
    //     $appointment->Updateby = $request->input('Updateby');
    //     // $Uuidapp = Str::uuid()->toString();
    //     $appointment->Uuid = $request->input('Uuid');
    //     $appointment->updated_at = DateThai(now());
    //     $appointment->update();

    //     return back();
    // }
}
