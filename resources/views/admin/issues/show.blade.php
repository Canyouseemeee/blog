@extends('layouts.master')

@section('title')
Web Test
@endsection

@section('content')

<?php
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate)) + 7;
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear $strHour:$strMinute น.";
}
?>
<form action="{{ url('issues-show/'.$data->Issuesid) }}" method="PUT">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Issues-View</h4>
                </div>
                <style>
                    .w-11p {
                        width: 900px;
                        word-break: break-all;
                    }
                </style>
                <div class="container">
                    <div class="card-body row">
                        <div class="" style="font-size:20px">
                            <div class="form-row ">
                                <div class="form-group col-md-3">
                                    <b> <label>Tracker : </label></b>
                                    @foreach($trackname as $row)
                                    @if ($row->Trackerid === $data->Trackerid)
                                    <label>{{$row->TrackName}}</label>
                                    @endif
                                    @endforeach
                                </div>

                                <div class="form-group col-md-3">
                                    <b> <label>SubTracker : </label></b>
                                    @foreach($trackname as $row)
                                    @if ($row->Trackerid === $data->Trackerid)
                                    <label>{{$row->SubTrackName}}</label>
                                    @endif
                                    @endforeach
                                </div>

                                <div class="form-group col-md-3">
                                    <b> <label>TrackName : </label></b>
                                    @foreach($trackname as $row)
                                    @if ($row->Trackerid === $data->Trackerid)
                                    <label>{{$row->Name}}</label>
                                    @endif
                                    @endforeach
                                </div>

                                <div class="form-group col-md-3">
                                    <b> <label>Priority : </label></b>
                                    @foreach($issuespriority as $row2)
                                    @if ($row2->Priorityid === $data->Priorityid)
                                    <label>{{$row2->ISPName}}</label>
                                    @endif
                                    @endforeach
                                </div>

                                <div class="form-group col-md-3">
                                    <b> <label>Status : </label></b>
                                    @foreach($issuesstatus as $row3)
                                    @if ($row3->Statusid === $data->Statusid)
                                    <label>{{$row3->ISSName}}</label>
                                    @endif
                                    @endforeach
                                </div>

                                <div class="form-group col-md-3">
                                    <b> <label>Department : </label></b>
                                    @foreach($department as $row4)
                                    @if ($row4->Departmentid === $data->Departmentid)
                                    <label>{{$row4->DmName}}</label>
                                    @endif
                                    @endforeach
                                </div>

                                <div class="form-group col-md-4">
                                    <b> <label>Users : </label></b>
                                    <label>{{$data->Users}}</label>
                                </div>
                            </div>
                            <div class="form-row ">
                                <div class="form-group col-md-4">
                                    <b> <label>Created : </label></b>
                                    <label>{{DateThai($data->created_at)}}</label>
                                </div>

                                <div class="form-group col-md-4">
                                    <b> <label>Updated : </label></b>
                                    <label>{{DateThai($data->updated_at)}}</label>
                                </div>

                                <div class="form-group col-md-4">
                                    <b> <label>Closed : </label></b>
                                    @if($data->closed_at == null)
                                        <label>ยังไม่ปิดงาน</label>
                                    @else
                                        <label>{{DateThai($data->closed_at)}}</label>
                                    @endif

                                </div>
                            </div>

                            <b><label>Subject : </label></b>
                            <div class="form-group col-md-6">
                                <label class="w-11p">{{$data->Subject}}</label>
                            </div>

                            <b><label>Description : </label></b>
                            <div class="form-group col-md-6">
                                <label class="w-11p">{{$data->Description}}</label>
                            </div>

                            <div class="form-group">
                                <b><label>Image : </label></b>
                                <img src="{{ asset('/storage/'.$data->Image) }}" alt="Image" width="500" />
                            </div>

                        </div>
                        <a href="{{ url('issues-edit/'.$data->Issuesid) }}" class="btn btn-primary">Edit</a>
                        &nbsp;&nbsp;
                        <a href="/issues" class="btn btn-danger">Back</a>
                        &nbsp;&nbsp;
                        <a href="{{ url('pdf/'.$data->Issuesid)}}" class="btn btn-warning"> PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection