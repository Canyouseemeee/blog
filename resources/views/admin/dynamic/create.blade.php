@extends('layouts.master2')

@section('title')
Web Test
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Dynamic-Create</h4>
            </div>
            <div class="card-body">
                <form action="{{ url('dynamic-store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <select name="TrackName" id="TrackName" class="form-control input-lg dynamic" data-dependent="SubTrackName">
                            <option value="">Select Trackname</option>
                            @foreach($trackname as $row)
                            <option value="{{$row->TrackName}}">{{$row->TrackName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <br />
                    <div class="form-group">
                        <select name="SubTrackName" id="SubTrackName" class="form-control input-lg dynamic">
                            <option value="">Select SubTrackName</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Name</label>
                                <input type="text" name="Name" class="form-control" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">SAVE</button>
                            <a href="/dynamic" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){

    $('.dynamic').change(function(){
        if($(this).val() != ''){
            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('dynamiccontroller.fetch') }}",
                method:"GET",
                data:{select:select, value:value, _token:
                _token, dependent:dependent},
                success:function(result){
                    $('#'+dependent).html(result);
                }
            })
        }
    });

});
</script>
@endsection