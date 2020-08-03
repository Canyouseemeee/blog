@extends('layouts.master')

@section('title')
Web Test
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Issues-Create
                    <a href="{{ url('category') }}" class="btn btn-primary float-right">Back</a>
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('addimage') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-row">
                        <div class="col-md-3">
                            <label>Tracker</label>
                            <select name="Trackerid" class="form-control create" require>
                                @foreach($issuestracker as $row)
                                <option value="{{$row->Trackerid}}">{{$row->ISTName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Priority</label>
                            <select name="Priorityid" class="form-control create" require>
                                @foreach($issuespriority as $row2)
                                <option value="{{$row->Priorityid}}">{{$row2->ISPName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="Statusid" class="form-control create" require>
                                @foreach($issuesstatus as $row3)
                                <option value="{{$row->Statusid}}">{{$row3->ISSName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Department</label>
                            <select name="Departmentid" class="form-control create" require>
                                @foreach($department as $row4)
                                <option value="{{$row->Departmentid}}">{{$row4->DmName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>User</label>
                            <text name="Users" class="form-control" readonly="readonly">{{Auth::user()->name}}</text>
                        </div>

                        <div class="form-group col-md-3">
                            <label>DateIn</label>
                            <text name="Users" class="form-control" readonly="readonly">{{now()->toDateString()}}</text>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="Subject" class="form-control" placeholder="Enter Subject">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" name="Description" class="form-control" placeholder="Enter Description"></textarea>
                    </div>

                    <div>
                        <input type="file" name="Image" class="custom-file-input">
                    </div>
                    <br>
                    <input type="submit" value="บันทึก" class="btn btn-primary ">
                    <a href="/issues" class="btn btn-success">ย้อนกลับ</a>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection