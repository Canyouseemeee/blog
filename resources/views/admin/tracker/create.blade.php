@extends('layouts.master2')

@section('title')
Web Test
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Tracker-Create</h4>
            </div>
            <div class="card-body">
                <form action="{{ url('tracker-store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Tracker Name</label>
                                <input type="text" name="ISTName" class="form-control" placeholder="Enter Tracker Name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> Tracker Description</label>
                                <textarea type="text" name="Description" class="form-control" placeholder="Enter Tracker Description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info">SAVE</button>
                            <a href="/tracker" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection