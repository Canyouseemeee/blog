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
                            <select name="TrackName" id="TrackName" class="form-control input-lg dynamic" data-dependent="SubTrackName">
                                <!-- <option value="">Select Trackname</option> -->
                                @foreach($issuestracker as $row)
                                <option value="{{$row->TrackName}}" 
                                    @if ($row->Trackerid === $data->Trackerid)
                                        selected
                                    @endif
                                    >{{$row->TrackName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>SubTracker</label>
                            <select name="SubTrackName" id="SubTrackName" class="form-control input-lg dynamic findidother" data-dependent="Name">
                                <!-- <option value="">Select SubTrackName</option> -->
                                @foreach($issuestracker as $row11)
                                <option value="{{$row->SubTrackName}}" 
                                    @if ($row11->Trackerid === $data->Trackerid)
                                        selected
                                    @endif
                                    >{{$row11->SubTrackName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Name</label>
                            <select name="Name" id="Name" class="form-control input-lg Name ">
                                <!-- <option value="">Select Name</option> -->
                                @foreach($issuestracker as $row12)
                                <option value="{{$row->Name}}" 
                                    @if ($row12->Trackerid === $data->Trackerid)
                                        selected
                                    @endif
                                    >{{$row12->Name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" value="{{$data->Trackerid}}" class="tracker_id" id="Trackerid" name="Trackerid">
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
                    url: '{!!URL::to('findid')!!}',
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
                url: '{!!URL::to('findidother')!!}',
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