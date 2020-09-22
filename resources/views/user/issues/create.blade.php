@extends('layouts.masteruser')

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
                @if($errors)
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <li>{{$error}}</li>
                </div>
                @endforeach
                @endif
                <form action="{{ url('issues-store-user') }}" method="post" enctype="multipart/form-data">
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
                                <option value="{{$row2->Priorityid}}">{{$row2->ISPName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="Statusid" class="form-control create"  require>
                                @foreach($issuesstatus as $row3)
                                <option value="{{$row3->Statusid}}">{{$row3->ISSName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Department</label>
                            <select name="Departmentid" class="form-control create" require>
                                @foreach($department as $row4)
                                <option value="{{$row4->Departmentid}}">{{$row4->DmCode}} - {{$row4->DmName}}</option>
                                @endforeach
                            </select>
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
                                <option value="{{$row5->id}}">{{$row5->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Tel</label>
                            <input name="Tel" class="form-control" placeholder="เบอร์ติดต่อกลับ">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Comname</label>
                            <input name="Comname" class="form-control" placeholder="ไม่จำเป็นต้องใส่ก็ได้">
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
                        <input type="file" id="Image" name="Image">
                    </div>
                    <br>
                    <input type="submit" value="Save" class="btn btn-primary ">
                    <a href="/issues-user" class="btn btn-danger">Back</a>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
                    url: '{!!URL::to("findid-user")!!}',
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

        $(document).on('change', '.findidother-user', function() {

            var tracker_id = $(this).val();
            var TrackName = $("#TrackName option:selected").val();
            var SubTrackName = $("#SubTrackName option:selected").val();
            var Name = $("#Name option:selected").val();
            var a = $(this).parent();
            // console.log(tracker_id);

            var op = "";
            $.ajax({
                type: 'get',
                url: '{!!URL::to("findidother-user")!!}',
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
@endsection