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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Issues-View
                    <a href="{{ url('issues') }}" class="btn btn-info float-right">Back</a>
                </h4>
            </div>
            <div class="card-body row">
                <div class="jumbotron" style="font-size:18px">
                    <div class="form-row ">
                        <div class="form-group col-md-3">
                            <b>{!! Form::label('Tracker : ') !!}</b>
                            @foreach($list as $row)
                            @if ($row->Trackerid === $data->Trackerid)
                            {!! Form::label($row->ISTName) !!}
                            @endif
                            @endforeach
                        </div>

                        <div class="form-group col-md-3">
                            <b>{!! Form::label('Priority : ') !!}</b>
                            @foreach($list2 as $row2)
                            @if ($row2->Priorityid === $data->Priorityid)
                            {!! Form::label($row2->ISPName) !!}
                            @endif
                            @endforeach
                        </div>

                        <div class="form-group col-md-3">
                            <b>{!! Form::label('Status : ') !!}</b>
                            @foreach($arealist as $row3)
                            @if ($row3->Statusid === $data->Statusid)
                            {!! Form::label($row3->ISSName) !!}
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <b>{!! Form::label('Category : ') !!}</b>
                            @foreach($arealist3 as $arealist3)
                            @if ($arealist3->Departmentid === $data->Departmentid)
                            {!! Form::label($arealist3->DmName) !!}
                            @endif
                            @endforeach
                        </div>

                        <div class="form-group col-md-2">
                            <b>{!! Form::label('Users : ') !!}</b>
                            {!! Form::label('users',$data->Users) !!}
                        </div>

                        <div class="form-group col-md-4">
                            <b>{!! Form::label('วันที่แจ้ง :') !!}</b>
                            {!! Form::label('Date_In',DateThai($data->Date_In)) !!}
                        </div>

                        <div class="form-group col-md-5">
                            <b>{!! Form::label('วันที่แก้ไขล่าสุด :') !!}</b>
                            {!! Form::label('update_at',DateThai($data->updated_at)) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <b>{!! Form::label('Subject :') !!}</b>
                        {!! Form::label('subject',$data->Subject,['style'=>'word-break:break-all']) !!}
                    </div>

                    <div class="form-group">
                        <b>{!! Form::label('Description :') !!}</b>
                        {!! Form::label('description',$data->Description,['style'=>'word-break:break-all']) !!}
                    </div>


                    
                </div>
                <a href="{{route('issues.edit',$data->Issuesid)}}" class="btn btn-primary">แก้ไข</a>
                <a href="/issues" class="btn btn-success">ย้อนกลับ</a>
            </div>
        </div>
    </div>
</div>sddasd
@endsection