@extends('layouts.master')

@section('title')
Web Test
@endsection

@section('content')

<?php
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $newDate = date('Y-m-d\TH:i', strtotime($strDate));
    return "$newDate";
    // return "$strDay-$strMonth-$strYear\T$strHour:$strMinute";
}
?>

<!-- Modal Appointments -->
<div class="modal fade" id="issueslistModal" tabindex="-1" role="dialog" aria-labelledby="issuesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="issuesModalLabel">Appointment Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form action="{{ url('/appointment-add') }}" method="post"> -->
            <form id="addform">
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">AppointDate</label>
                        <input type="dateTime-local" id="AppointDate" name="AppointDate" value="{{now()->toDateString()}}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Comment</label>
                        <textarea id="Comment" name="Comment" class="form-control" rows="3" placeholder="Enter Comment"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Status</label>
                        <select id="Status" name="Status" class="form-control" require>
                            <option value="1">Active</option>
                            <option value="2">Change</option>
                            <option value="3">Disable</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Createby</label>
                        <input type="text" name="Createby" class="form-control" value="{{Auth::user()->name}}" placeholder="{{Auth::user()->name}}" readonly>
                    </div>

                    <div class="form-group">
                        <!-- <label for="">Uuid</label> -->
                        <input id="tempappoint" name="temp" class="form-control" placeholder="{{$temp}}" value="{{$temp}}" hidden>
                    </div>

                    <div id="result">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="appointmentclosed" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="savemodal" name="action" value="save" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

@if(!is_null($appointment))
<!-- Edit Modal Appointments -->
@foreach($appointment as $row)
<div class="modal fade" id="issueseditModal" tabindex="-1" role="dialog" aria-labelledby="issuesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="issuesModalLabel">Appointment Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form action="{{ url('/appointment-edit') }}" method="post"> -->
            <form id="editform">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-body">


                    <div class="form-group">
                        <label for="">AppointDate</label>
                        <input type="dateTime-local" id="AppointDateedit" name="AppointDate" value="{{DateThai($row->Date)}}" class="form-control">
                        <!-- <input type="text" id="AppointDate" placeholder=""> -->
                    </div>

                    <div class="form-group">
                        <label for="">Comment</label>
                        <textarea id="Commentedit" name="Comment" class="form-control" rows="3">{{$row->Comment}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Status</label>
                        <select id="Statusedit" name="Status" class="form-control" require>
                            <option value="1" @if ($row->Status === 1)
                                selected
                                @endif>Active</option>
                            <option value="2" @if ($row->Status === 2)
                                selected
                                @endif>Change</option>
                            <option value="3" @if ($row->Status === 3)
                                selected
                                @endif>Disable</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Updateby</label>
                        <input type="text" id="Updateby" name="Updateby" class="form-control" value="{{Auth::user()->name}}" placeholder="{{Auth::user()->name}}" readonly>
                    </div>

                    <div class="form-group">
                        <!-- <label for="">Uuid</label> -->
                        <input name="Uuid" class="form-control" placeholder="{{$row->Uuid}}" value="{{$row->Uuid}}" hidden>
                    </div>

                    <div class="form-group">
                        <!-- <label for="">Uuid</label> -->
                        <input name="Issuesid" class="form-control" placeholder="{{$row->Issuesid}}" value="{{$row->Issuesid}}" hidden>
                    </div>

                    <div id="resultedit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="editclosed" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editmodal" name="action" value="save" class="btn btn-primary">Save changes</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endforeach
<!-- End Edit Appointments Modal -->
@endif

<!-- Modal Comments -->
<div class="modal fade" id="issuescommentsModal" tabindex="-1" role="dialog" aria-labelledby="issuesModalComments" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="issuesModalComments">Comments Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form action="{{ url('/appointment-add') }}" method="post"> -->
            <form id="addformcomment" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Comment</label>
                        <textarea id="CComment" name="CComment" class="form-control" rows="3" placeholder="Enter Comment"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Image</label><br>
                        <input type="file" id="image" name="image">
                    </div>

                    <div class="form-group">
                        <label for="">Createby</label>
                        <input type="text" id="CCreateby" name="CCreateby" class="form-control" value="{{Auth::user()->name}}" placeholder="{{Auth::user()->name}}" readonly>
                    </div>

                    <div class="form-group">
                        <!-- <label for="">Uuid</label> -->
                        <input id="Ctemp" name="Ctemp" class="form-control" placeholder="{{$temp}}" value="{{$temp}}" hidden>

                    </div>

                    <div id="resultcomment">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closedcomment" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="savecomment" name="action" value="save" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Comments -->

<button type="button" class="btn btn-warning btn_showIssues">Issues Create</button>
<button type="button" class="btn btn-primary btn_showComments">Comments</button>
<button type="button" class="btn btn-danger btn_showAppointments">Appointments</button>

<div class="row subissues">
    <div class="col-md-12">
        <div class="card card-nav-tabs card-plain">
            <div class="card-header ">
                <h4 class="card-title"> Issues-Create</h4>
            </div>
            <div class="card-body ">
                @if($errors)
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <li>{{$error}}</li>
                </div>
                @endforeach
                @endif
                <form action="{{ url('issues-store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-row">

                        <div class="col-md-3">
                            <label>Tracker</label>
                            <select name="TrackName" id="TrackName" class="form-control input-lg dynamic" data-dependent="SubTrackName">
                                <option value="">Select Trackname</option>
                                @foreach($tracker as $row)
                                <option value="{{$row->TrackName}}">{{$row->TrackName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>SubTracker</label>
                            <select name="SubTrackName" id="SubTrackName" class="form-control input-lg dynamic findidother" data-dependent="Name" disabled>
                                <option value="">Select SubTrackName</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Name</label>
                            <select name="Name" id="Name" class="form-control input-lg Name " disabled>
                                <option value="">Select Name</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="tracker_id" id="Trackerid" name="Trackerid">
                        </div>


                        <div class="col-md-3">
                            <label>Priority</label>
                            <select name="Priorityid" class="form-control create" require>
                                @foreach($issuespriority as $row2)
                                <option value="{{$row2->Priorityid}}" @if (old("Priorityid")==$row2->Priorityid) selected @endif>{{$row2->ISPName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="Statusid" class="form-control create" require>
                                <option value="1" @if (old("Statusid")==1) selected @endif>New</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Department</label>
                            <p>
                                <select id="Departmentid" name="Departmentid" class="form-control-lg create col-md-12" require>
                                    @foreach($department as $row4)
                                    <option value="{{$row4->Departmentid}}" @if (old("Departmentid")==$row4->Departmentid) selected @endif>{{$row4->DmCode}} - {{$row4->DmName}}</option>
                                    @endforeach
                                </select></p>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Createby</label>
                            <input name="Createby" class="form-control" readonly="readonly" value="{{Auth::user()->name}}" placeholder="{{Auth::user()->name}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Date</label>
                            <input name="Date_In" class="form-control" readonly="readonly" value="{{now()->toDateString()}}" placeholder="{{now()->toDateString()}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Assignment</label>
                            <select name="Assignment" class="form-control create" require>
                                <option value="">Select Assignment</option>
                                @foreach($user as $row5)
                                <option value="{{$row5->id}}" @if (old("Assignment")==$row5->id) selected @endif>{{$row5->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Tel</label>
                            <input name="Tel" class="form-control" placeholder="เบอร์แผนก" value="{{old('Tel')}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Comname</label>
                            <input name="Comname" class="form-control" placeholder="ไม่จำเป็นต้องใส่" value="{{old('Comname')}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Informer</label>
                            <input name="Informer" class="form-control" placeholder="รหัสเจ้าหน้าที่" value="{{old('Informer')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="Subject" class="form-control" placeholder="Enter Subject" value="{{old('Subject')}}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" name="Description" class="form-control" placeholder="Enter Description">{{old('Description')}}</textarea>
                    </div>

                    <div class="form-group col-md-3">
                        <!-- <label>Uuid</label> -->
                        <input name="temp" class="form-control" placeholder="{{$temp}}" value="{{$temp}}" hidden>
                    </div>

                    <div>
                        <input type="file" id="Image" name="Image">
                    </div>
                    <br>
                    <input type="submit" value="Save" class="btn btn-primary ">
                    <a href="/issues" class="btn btn-danger">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
&nbsp;
<div class="row panelsub_all subappoint">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="" class="btn btn-primary float-right" data-toggle="modal" data-target="#issueslistModal">Appointment Add</a>
                <h4 class="card-title">Appointment Issues </h4>

            </div>
            <style>
                .w-10p {
                    width: 10% !important;
                }

                .w-11p {
                    width: 300px;
                    word-break: 'break-all';
                }
            </style>
            <div class="card-body" id="refresh">
                @if(!is_null($appointment))
                <table id="datatableappoint" class="table">
                    <thead class="text-primary">
                        <th>Date</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Createby</th>
                        <th>Updateby</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Edit</th>
                    </thead>
                    <tbody id="datatableappointbody">
                        @foreach($appointment as $row)
                        <tr>
                            <td>{{$row->Date}}</td>
                            <td>
                                <div class="w-11p" style="height: 30px; overflow: hidden;">
                                    {{$row->Comment}}
                                </div>
                            </td>
                            @if($row->Status === 1)
                            <td>Active</td>
                            @elseif($row->Status === 2)
                            <td>Change</td>
                            @elseif($row->Status === 3)
                            <td>Disable</td>
                            @endif
                            <td>{{$row->Createby}}</td>
                            <td>{{$row->Updateby}}</td>
                            <td>{{$row->created_at}}</td>
                            <td>{{$row->updated_at}}</td>
                            @if($row->Status === 1)
                            <td>
                                <a href="" data-toggle="modal" data-target="#issueseditModal" class="btn btn-success">Edit</a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <table id="datatableappoint" class="table">
                    <thead class="text-primary">
                        <th>Date</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Createby</th>
                        <th>Updateby</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Edit</th>
                    </thead>
                    <tbody id="datatableappointbody">
                        <tr>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- <div class="row panelsub_all subcomment">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="" class="btn btn-primary float-right" data-toggle="modal" data-target="#issuescommentsModal">Comments Add</a>
                <h4 class="card-title">Comments</h4>

            </div>
            <style>
                .elevation-2 {
                    box-shadow: 0 3px 6px rgba(0, 0, 0, .16), 0 3px 6px rgba(0, 0, 0, .23) !important;
                }

                .img-circle {
                    border-radius: 50%;
                }

                .w-11p {
                    width: 300px;
                    word-break: 'break-all';
                }
            </style>
            <div class="card-body">
                @if(!is_null($comment))

                <table id="datatablecomment" class="table">
                    <thead class="text-primary">
                        <th>Image</th>
                        <th>Type</th>
                        <th>Comment</th>
                        <th>Createby</th>
                        <th>Updateby</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Status</th>
                    </thead>
                    <tbody id="datatablecommentbody">
                        @foreach($comment as $row)
                        <tr>
                            @if(!is_null($row->Image))
                            <td><img src="{{ url('storage/'.$row->Image) }}" class="img-circle elevation-2" alt="image" width="80" height="80"></td>
                            @else
                            <td>ไม่มีรูปภาพ</td>
                            @endif
                            @if($row->Type === 1)
                            <td>App</td>
                            @elseif($row->Type === 0)
                            <td>Web</td>
                            @endif
                            <td>
                                <div class="w-11p" style="height: 30px; overflow: hidden;">
                                    {{$row->Comment}}
                                </div>
                            </td>
                            <td>{{$row->Createby}}</td>
                            <td>{{$row->Updateby}}</td>
                            <td>{{$row->created_at}}</td>
                            <td>{{$row->updated_at}}</td>
                            @if($row->Status === 1)
                            <td>Active</td>
                            @elseif($row->Status === 0)
                            <td>UnActive</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <table id="datatablecomment" class="table">
                    <thead class="text-primary">
                        <th>Image</th>
                        <th>Type</th>
                        <th>Comment</th>
                        <th>Createby</th>
                        <th>Updateby</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>Status</th>
                    </thead>
                    <tbody id="datatablecommentbody">
                        <tr>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                            <td>ไม่มีข้อมูลที่จะแสดง</td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div> -->
<div class="row panelsub_all subcomment">
    <style>
        .elevation-2 {
            box-shadow: 0 3px 6px rgba(0, 0, 0, .16), 0 3px 6px rgba(0, 0, 0, .23) !important;
        }

        .img-circle {
            border-radius: 50%;
        }

        .username {
            font-size: 16px;
            font-weight: 600;
            margin-top: -1px;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: #fff;

            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .user-block .description {
            color: #6c757d;
            font-size: 13px;
            margin-top: -3px;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
            background-color: #fff;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        .card-widget {
            border: 0;
            position: relative;
            border-top: 0;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
    </style>
    <div class="col-md-12">
        <!-- Box Comment -->
        <div class="card card-widget">
            <div class="card-header">
                <h4 class="card-title"> Comments <a href="" class="btn btn-primary float-right" data-toggle="modal" data-target="#issuescommentsModal">Comments Add</a></h4>
            </div>
            @foreach($comment as $row)
            <div class="card-header">
                <div class="user-block">
                    <img class="img-circle" src="{{ url('storage/'.$row->Image) }}" alt="Image" width="50" height="50">
                    <span class="username">{{$row->Createby}}</span>
                    <span class="description">{{$row->created_at}}</span>
                </div>

                <!-- /.user-block -->
                <!-- <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Mark as read">
                        <i class="far fa-circle"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </button>
                </div> -->
                <!-- /.card-tools -->
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-default btn-sm float-right"><i class="fas fa-comment-slash"></i></i> Unsend</button>
                <img class="img-fluid pad center" src="{{ url('storage/'.$row->Image) }}" style="align-items: center;" width="555" height="550" alt="Photo">
                <p style="padding-top: 20px;">{{$row->Comment}}</p>
                <span class="float-right text-muted">updated {{$row->updated_at}} By {{$row->Updateby}}</span>
            </div>
            <div class="card-footer">
                <br>
            </div>
            @endforeach
        </div>
    </div>
    @endsection

    @section('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {

            $('.dynamic').change(function() {
                var TrackName = $("#TrackName option:selected").val();
                if (TrackName != '') {
                    var select = $(this).attr("id");
                    var dependent = $(this).data('dependent');

                    var TrackName = $("#TrackName option:selected").val();
                    var SubTrackName = $("#SubTrackName option:selected").val();
                    var Name = $("#Name option:selected").val();
                    console.log(select);
                    console.log(TrackName);
                    console.log(SubTrackName);
                    console.log(Name);
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('dynamiccontroller.fetch') }}",
                        method: "GET",
                        data: {
                            select: select,
                            TrackName: TrackName,
                            SubTrackName: SubTrackName,
                            Name: Name,
                            _token: _token,
                            dependent: dependent
                        },
                        success: function(result) {
                            $('#' + dependent).html(result);
                            $('#SubTrackName').prop('disabled', false);

                        }
                    });
                }
                if (TrackName == '') {
                    $('#SubTrackName').empty().append('<option>Select SubTrackName</option>');;
                    $('#Name').html('<option value="">Select Name</option>');
                    $('#tracker_id').val('');
                    $('#Name').prop('disabled', false);
                }
                if (SubTrackName != '') {
                    $('#Name').html('<option value="">Select Name</option>');
                    $('#tracker_id').val('');
                    $('#Name').prop('disabled', false);

                }
                if (SubTrackName == 'Other') {
                    $('#Name').prop('disabled', 'disabled');
                }
                if (SubTrackName != 'Other') {
                    $('#Name').prop('disabled', false);
                }
            });



            $(document).on('change', '.Name', function() {
                var SubTrackName = $("#SubTrackName option:selected").val();
                if (SubTrackName != 'Other') {
                    var tracker_id = $(this).val();
                    var TrackName = $("#TrackName option:selected").val();
                    var SubTrackName = $("#SubTrackName option:selected").val();
                    var Name = $("#Name option:selected").val();
                    var a = $(this).parent();
                    // console.log(tracker_id);

                    var op = "";
                    $.ajax({
                        type: 'get',
                        url: '{!!URL::to("findid")!!}',
                        data: {
                            // 'Name': tracker_id,
                            TrackName: TrackName,
                            SubTrackName: SubTrackName,
                            Name: Name,
                        },
                        dataType: 'json', //return data will be json
                        success: function(data) {
                            // console.log("Trackerid","3");
                            // console.log(len(data));
                            console.log(data);

                            // here price is coloumn name in products table data.coln name
                            $('#Trackerid').val(data);
                            // a.find('.tracker_id').val(data.Name);
                            // console.log(data = JSON.parse(data));



                        },
                        error: function() {

                        }
                    });
                }

            });

            $(document).on('change', '.findidother', function() {

                var tracker_id = $(this).val();
                var TrackName = $("#TrackName option:selected").val();
                var SubTrackName = $("#SubTrackName option:selected").val();
                var Name = $("#Name option:selected").val();
                var a = $(this).parent();
                // console.log(tracker_id);

                var op = "";
                $.ajax({
                    type: 'get',
                    url: '{!!URL::to("findidother")!!}',
                    data: {
                        TrackName: TrackName,
                        SubTrackName: SubTrackName,
                        Name: Name,
                    },
                    dataType: 'json', //return data will be json
                    success: function(data) {
                        // console.log("Trackerid","3");
                        // console.log(len(data));
                        console.log(data);

                        // here price is coloumn name in products table data.coln name
                        $('#Trackerid').val(data);
                        // a.find('.tracker_id').val(data.Name);
                        // console.log(data = JSON.parse(data));

                    },
                    error: function() {

                    }
                });


            });

        });
    </script>

    <script>
        $('#Departmentid').select2({
            placeholder: " Enter Department",
            minimumInputLength: 1,
            delay: 250,
            allowClear: true,
        });
    </script>

    <script>
        var auto_refresh;

        $('.panelsub_all').hide();

        $('.btn_showAppointments').click(function(e) {
            e.preventDefault();
            $('.subappoint').show();
            $('.subissues').hide();
            $('.subcomment').hide();
        });

        $('.btn_showIssues').click(function(e) {
            e.preventDefault();
            $('.subappoint').hide();
            $('.subissues').show();
            $('.subcomment').hide();
        });

        $('.btn_showComments').click(function(e) {
            e.preventDefault();
            $('.subappoint').hide();
            $('.subissues').hide();
            $('.subcomment').show();
        });

        $(document).ready(function() {

            $('#editform').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "PUT",
                    url: "/appointment-edit",
                    data: $('#editform').serialize(),
                    success: function(response) {
                        console.log(response);
                        $('#editmodal').attr('disabled', 'disabled');
                        $('#AppointDateedit').attr('readonly', 'readonly');
                        $('#Commentedit').attr('readonly', 'readonly');
                        $('#Statusedit').attr('disabled', 'disabled');
                        $("#resultedit").html('<div class="alert alert-success" role="alert" id="result">Appointment Update Success</div>');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $('#editclosed').click(function() {

                $('#datatableappointbody').empty();
                var temp = $('#tempappoint').val();
                $.ajax({
                    type: "POST",
                    data: {
                        temp: temp
                    },
                    url: "/api/appointmentlist",
                    success: function(response) {
                        $('#editmodal').removeAttr('disabled');
                        $('#AppointDateedit').removeAttr('readonly');
                        $('#Commentedit').removeAttr('readonly');
                        $('#Statusedit').removeAttr('disabled');
                        $("#resultedit").empty();
                        var len = response.length;
                        if (len > 0) {
                            var irow = response.length;
                            var i = 0;
                            var rown = 1;
                            for (i = 0; i < irow; i++) {
                                var html = "<tr>";
                                html += '<td>' + response[i].Date + '</td>';
                                html += '<td><div class="w-11p" style="height: 30px; overflow: hidden;">' + response[i].Comment + '</div></td>';
                                if (response[i].Status == 1) {
                                    html += '<td>Active</td>';
                                }
                                if (response[i].Status == 2) {
                                    html += '<td>Change</td>';
                                }
                                if (response[i].Status == 3) {
                                    html += '<td>Disable</td>';
                                }
                                html += '<td>' + response[i].Createby + '</td>';
                                html += '<td>' + response[i].Updateby + '</td>';
                                html += '<td>' + response[i].created_at + '</td>';
                                html += '<td>' + response[i].updated_at + '</td>';
                                if (response[i].Status == 1) {
                                    html += '<td><a href="" data-toggle="modal" data-target="#issueseditModal" class="btn btn-success">Edit</a></td>';
                                }
                                html += '</tr>';
                                $('#datatableappointbody').append(html);
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $('#addform').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "/appointment-add",
                    data: $('#addform').serialize(),
                    success: function(response) {
                        console.log(response);
                        // alert("Data Saved");
                        $('#savemodal').attr('disabled', 'disabled');
                        $('#AppointDate').attr('readonly', 'readonly');
                        $('#Comment').attr('readonly', 'readonly');
                        $('#Status').attr('disabled', 'disabled');
                        $("#result").html('<div class="alert alert-success" role="alert" id="result">Appointment Save Success</div>');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $('#appointmentclosed').click(function() {

                $('#datatableappointbody').empty();
                var temp = $('#tempappoint').val();
                $.ajax({
                    type: "POST",
                    data: {
                        temp: temp
                    },
                    url: "/api/appointmentlist",
                    success: function(response) {
                        $('#savemodal').removeAttr('disabled').val("");
                        $('#AppointDate').removeAttr('readonly').val("");
                        $('#Comment').removeAttr('readonly').val("");
                        $('#Status').removeAttr('disabled');
                        $("#result").empty();
                        var len = response.length;
                        if (len > 0) {
                            var irow = response.length;
                            var i = 0;
                            var rown = 1;
                            for (i = 0; i < irow; i++) {
                                var html = "<tr>";
                                html += '<td>' + response[i].Date + '</td>';
                                html += '<td><div class="w-11p" style="height: 30px; overflow: hidden;">' + response[i].Comment + '</div></td>';
                                if (response[i].Status == 1) {
                                    html += '<td>Active</td>';
                                }
                                if (response[i].Status == 2) {
                                    html += '<td>Change</td>';
                                }
                                if (response[i].Status == 3) {
                                    html += '<td>Disable</td>';
                                }
                                html += '<td>' + response[i].Createby + '</td>';
                                html += '<td>' + response[i].Updateby + '</td>';
                                html += '<td>' + response[i].created_at + '</td>';
                                html += '<td>' + response[i].updated_at + '</td>';
                                if (response[i].Status == 1) {
                                    html += '<td><a href="" data-toggle="modal" data-target="#issueseditModal" class="btn btn-success">Edit</a></td>';
                                }
                                html += '</tr>';
                                $('#datatableappointbody').append(html);
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        $(document).ready(function() {

            $('#addformcomment').on('submit', function(e) {
                e.preventDefault();
                var form = $('#addformcomment')[0];

                var data = new FormData(form);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "/comments-add",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(response) {
                        console.log(response);
                        // alert("Data Saved");
                        $('#savecomment').attr('disabled', 'disabled');
                        $('#CComment').attr('readonly', 'readonly');
                        $("#resultcomment").html('<div class="alert alert-success" role="alert" id="result">Comments Save Success</div>');
                    },
                    error: function(error) {
                        console.log(error);
                        // alert("Data error");

                    }
                });
            });

            $('#closedcomment').click(function() {

                $('#datatablecommentbody').empty();
                var temp = $('#Ctemp').val();
                $.ajax({
                    type: "POST",
                    data: {
                        temp: temp
                    },
                    url: "/api/commentlist",
                    success: function(response) {
                        $('#savecomment').removeAttr('disabled');
                        $('#CComment').removeAttr('readonly').val("");
                        $("#resultcomment").empty();
                        $('#image').val("");
                        var len = response.length;
                        if (len > 0) {
                            var irow = response.length;
                            var i = 0;
                            var rown = 1;
                            for (i = 0; i < irow; i++) {
                                var html = "<tr>";
                                if (response[i].Image != null) {
                                    html += '<td><img src="http://10.57.34.148:8000/storage/' + response[i].Image + '" alt="image" width="80" height="80"></td>';
                                }
                                if (response[i].Image == null) {
                                    html += '<td>ไม่มีรูปภาพ</td>';
                                }
                                if (response[i].Type == 1) {
                                    html += '<td>App</td>';
                                }
                                if (response[i].Type == 0) {
                                    html += '<td>Web</td>';
                                }
                                html += '<td><div class="w-11p" style="height: 30px; overflow: hidden;">' + response[i].Comment + '</div></td>';
                                html += '<td>' + response[i].Createby + '</td>';
                                html += '<td>' + response[i].Updateby + '</td>';
                                html += '<td>' + response[i].created_at + '</td>';
                                html += '<td>' + response[i].updated_at + '</td>';
                                if (response[i].Status == 1) {
                                    html += '<td>Active</td>';
                                }
                                if (response[i].Status == 0) {
                                    html += '<td>UnActive</td>';
                                }
                                html += '</tr>';
                                $('#datatablecommentbody').append(html);
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

    @endsection