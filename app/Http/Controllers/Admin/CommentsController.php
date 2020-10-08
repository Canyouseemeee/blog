<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssuesComment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate(
            $request,
            array(
                'Comments' => 'required',
            ),
        );

        $comment = new IssuesComment();
        $comment->Issuesid = 0;
        $comment->Type = 0;
        $comment->Comment = $request->input('Comments');
        $comment->Uuid = $request->input('temp');
        $comment->Createby = $request->input('Createby');
        $comment->created_at = DateThai(now());
        $comment->updated_at = DateThai(now());

        if ($request->hasFile('ImageComments')) {
            $filename = $request->ImageComments->getClientOriginalName();
            $file = time() . '.' . $filename;
            $comment->Image = $request->ImageComments->storeAs('images', $file, 'public');
            // dd($file);
        } else {
            $comment->Image = null;
        }

       
        return back()->with('status', 'Data Added for Comments Successfully');
    }
}
