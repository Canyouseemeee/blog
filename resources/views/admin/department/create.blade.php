@extends('layouts.master')

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
                                @if($errors->has('DmName'))
                                <div class="alert alert-danger">
                                    <li>{{$errors->first('DmName')}}</li>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> Department Tel</label>
                                <input type="text" name="Dm_Tel" class="form-control" placeholder="Enter Department Tel">
                                @if($errors->has('Dm_Tel'))
                                <div class="alert alert-danger">
                                    <li>{{$errors->first('Dm_Tel')}}</li>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">SAVE</button>
                            <a href="/department" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection