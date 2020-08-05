@extends('layouts.master2')

@section('title')
Web Test
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Department-Create</h4>
            </div>
            <div class="card-body">
                <form action="{{ url('department-store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Department Name</label>
                                <input type="text" name="DmName" class="form-control" placeholder="Enter Department Name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> Department Tel</label>
                                <input type="text" name="Dm_Tel" class="form-control" placeholder="Enter Department Tel">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info">SAVE</button>
                            <a href="/department" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection