@extends('layouts.master2')

@section('title')
Web Test
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Priority-Create</h4>
            </div>
            <div class="card-body">
                <form action="{{ url('priority-store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Priority Name</label>
                                <input type="text" name="ISPName" class="form-control" placeholder="Enter Priority Name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> Priority Description</label>
                                <textarea type="text" name="Description" class="form-control" placeholder="Enter Priority Description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info">SAVE</button>
                            <a href="/priority" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection