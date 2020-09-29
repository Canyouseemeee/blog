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

<!-- Modal -->
<div class="modal fade" id="issueslistModal" tabindex="-1" role="dialog" aria-labelledby="issuesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="issuesModalLabel">Appointment Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/appointment-add') }}" method="post">
                {{ csrf_field() }}

                <div class="modal-body">

                    <div class="form-group">
                        <label for="">AppointDate</label>
                        <input type="dateTime-local" id="AppointDate" name="AppointDate" value="{{now()->toDateString()}}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Comment</label>
                        <textarea name="Comment" class="form-control" rows="3" placeholder="Enter Comment"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="Status" class="form-control" require>
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
                        <input name="temp" class="form-control" placeholder="{{$temp}}" value="{{$temp}}" hidden>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="action" value="save" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

@if(!is_null($appointment))
<!-- Edit Modal -->
<div class="modal fade" id="issueseditModal" tabindex="-1" role="dialog" aria-labelledby="issuesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="issuesModalLabel">Appointment Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/appointment-edit') }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-body">

                    @foreach($appointment as $app)
                    <div class="form-group">
                        <label for="">AppointDate</label>
                        <input type="dateTime-local" id="AppointDate" name="AppointDate" value="{{DateThai($app->Date)}}" class="form-control">
                        <!-- <input type="text" id="AppointDate" placeholder=""> -->
                    </div>

                    <div class="form-group">
                        <label for="">Comment</label>
                        <textarea name="Comment" class="form-control" rows="3">{{$app->Comment}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="Status" class="form-control" require>
                            <option value="1" @if ($app->Status === 1)
                                selected
                                @endif>Active</option>
                            <option value="2" @if ($app->Status === 2)
                                selected
                                @endif>Change</option>
                            <option value="3" @if ($app->Status === 3)
                                selected
                                @endif>Disable</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Updateby</label>
                        <input type="text" name="Updateby" class="form-control" value="{{Auth::user()->name}}" placeholder="{{Auth::user()->name}}" readonly>
                    </div>

                    <div class="form-group">
                        <!-- <label for="">Uuid</label> -->
                        <input name="temp" class="form-control" placeholder="{{$temp}}" value="{{$temp}}" hidden>

                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="action" value="save" class="btn btn-primary">Save changes</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End Edit Modal -->
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Issues-Create</h4>
            </div>
            <div class="card-body">
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
                    <a href="" class="btn btn-primary float-right" data-toggle="modal" data-target="#issueslistModal">Appointment Add</a>
                </form>
            </div>
        </div>
    </div>
</div>
&nbsp;
@if(!is_null($appointment))
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Appointment Issues</h4>
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
            <div class="card-body">
                <table id="datatable" class="table">
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
                    <tbody>
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
                            <td>
                                <a href="" data-toggle="modal" data-target="#issueseditModal" class="btn btn-success">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
        // ajax: {
        //     url: '{{ route("select2") }}',
        //     dataType: 'json',
        //     delay: 200,
        //     data: function(params) {
        //         return {
        //             q: $.trim(params.term)
        //         };
        //     },
        //     processResults: function(data) {
        //         return {
        //             results: data
        //         };
        //     },
        //     cache: true
        // }
    });
</script>

@endsection