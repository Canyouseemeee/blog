@extends('layouts.masteruser')

@section('title')
Web Test
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Issues-Edit</h4>
            </div>
            <div class="card-body">
                @if($errors)
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <li>{{$error}}</li>
                </div>
                @endforeach
                @endif
                <form action="{{ url('issues-update-user/'.$data->Issuesid) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-row">

                        <div class="col-md-3">
                            <label>Tracker</label>
                            <select name="TrackName" id="TrackName" class="form-control input-lg dynamic" data-dependent="SubTrackName">
                                @foreach($find as $find1)
                                @foreach($trackname as $row)
                                <option value="{{$row->TrackName}}" @if ($row->TrackName === $find1->TrackName)
                                    selected
                                    @endif
                                    >{{$row->TrackName}}</option>
                                @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>SubTracker</label>
                            <select name="SubTrackName" id="SubTrackName" class="form-control input-lg dynamic findidother" data-dependent="Name" disabled>
                                <!-- <option value="">Select SubTrackName</option> -->
                                @foreach($tracker as $row11)
                                <option value="" @if ($row11->Trackerid === $data->Trackerid)
                                    selected
                                    @endif
                                    >{{$row11->SubTrackName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Name</label>
                            <select name="Name" id="Name" class="form-control input-lg Name " disabled>
                                <!-- <option value="">Select Name</option> -->
                                @foreach($tracker as $row12)
                                <option value="" @if ($row12->Trackerid === $data->Trackerid)
                                    selected
                                    @endif
                                    >{{$row12->Name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="hidden" value="{{$data->Trackerid}}" class="tracker_id" id="Trackerid" name="Trackerid">
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
                            @if($data->Statusid === 2)
                            <select name="Statusid" class="form-control create" require disabled>
                                @foreach($issuesstatus as $row3)
                                <option value="{{$row3->Statusid}}" @if ($row3->Statusid === $data->Statusid)
                                    selected
                                    @endif
                                    >{{$row3->ISSName}}</option>
                                @endforeach
                            </select>
                            @else
                            <select name="Statusid" class="form-control create" require>
                                @foreach($issuesstatus as $row3)
                                <option value="{{$row3->Statusid}}" @if ($row3->Statusid === $data->Statusid)
                                    selected
                                    @endif
                                    >{{$row3->ISSName}}</option>
                                @endforeach
                            </select>

                            @endif

                        </div>

                        <div class="col-md-3">
                            <label>Department</label>
                            <p>
                                <select id="Departmentid" name="Departmentid" class="form-control create col-md-12" require>
                                    @foreach($department as $row4)
                                    <option value="{{$row4->Departmentid}}" @if ($row4->Departmentid === $data->Departmentid)
                                        selected
                                        @endif
                                        >{{$row4->DmCode}} - {{$row4->DmName}}</option>
                                    @endforeach
                                </select>
                            </p>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Updatedby</label>
                            <input name="Updatedby" class="form-control" readonly="readonly" value="{{Auth::user()->name}}" placeholder="{{Auth::user()->name}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>DateIn</label>
                            <input name="Date_In" class="form-control" readonly="readonly" value="{{$data->Date_In}}" placeholder="{{$data->Date_In}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Assignment</label>
                            <select name="Assignment" class="form-control create" require>
                                @foreach($user as $row5)
                                <option value="{{$row5->id}}" @if ($row5->id === $data->Assignment)
                                    selected
                                    @endif
                                    >{{$row5->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Tel</label>
                            <input name="Tel" class="form-control" value="{{$data->Tel}}" placeholder="{{$data->Tel}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Comname</label>
                            <input name="Comname" class="form-control" value="{{$data->Comname}}" placeholder="{{$data->Comname}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Informer</label>
                            <input name="Informer" class="form-control" placeholder="{{$data->Informer}}" value="{{$data->Informer}}">
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
                        <input type="hidden" name="Image2" value="{{$data->Image}}">
                        <input type="file" name="Image">
                    </div>
                    <br>
                    <input type="submit" value="Update" class="btn btn-primary ">
                    <a href="{{ url('issues-show-user/'.$data->Issuesid) }}" class="btn btn-danger">Back</a>

                </form>
            </div>
        </div>
    </div>
</div>
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
            if (SubTrackName == '') {
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

<script>
    $('#Departmentid').select2({
        placeholder: " Enter Department",
        minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        
        // ajax: {
        //     url: '/issues-select2',
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