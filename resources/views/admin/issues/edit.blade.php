@extends('layouts.master2')

@section('title')
Web Test
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Issues-Create</h4>
            </div>
            <div class="card-body">
                <form action="{{ url('issues-update/'.$data->Issuesid) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-row">
                        <div class="col-md-3">
                            <label>Tracker</label>
                            <select name="Trackerid" class="form-control create" require>
                                @foreach($issuestracker as $row)
                                <option value="{{$row->Trackerid}}" @if ($row->Trackerid === $data->Trackerid)
                                    selected
                                    @endif
                                    >{{$row->ISTName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Priority</label>
                            <select name="Priorityid" class="form-control create" require>
                                @foreach($issuespriority as $row2)
                                <option value="{{$row2->Priorityid}}" @if ($row2->Priorityid === $data->Priorityid)
                                    selected
                                    @endif
                                    >{{$row2->ISPName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="Statusid" class="form-control create" require>
                                @foreach($issuesstatus as $row3)
                                <option value="{{$row3->Statusid}}" @if ($row3->Statusid === $data->Statusid)
                                    selected
                                    @endif
                                    >{{$row3->ISSName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Department</label>
                            <select name="Departmentid" class="form-control create" require>
                                @foreach($department as $row4)
                                <option value="{{$row4->Departmentid}}" @if ($row4->Departmentid === $data->Departmentid)
                                    selected
                                    @endif
                                    >{{$row4->DmName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>User</label>
                            <input name="Users" class="form-control" readonly="readonly" value="{{Auth::user()->name}}" placeholder="{{Auth::user()->name}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>DateIn</label>
                            <input name="Date_In" class="form-control" readonly="readonly" value="{{$data->Date_In}}" placeholder="{{$data->Date_In}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="Subject" class="form-control" value="{{$data->Subject}}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" name="Description" class="form-control">{{$data->Description}}</textarea>
                    </div>

                    <div>
                        <input type="file" name="Image" value="{{$data->Image}}">
                    </div>
                    <br>
                    <input type="submit" value="Update" class="btn btn-success ">
                    <a href="{{ url('issues-show/'.$data->Issuesid) }}" class="btn btn-danger">Back</a>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection