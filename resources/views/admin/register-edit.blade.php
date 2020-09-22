@extends('layouts.master')

@section('title')
Register Edit
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Edit User') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="/role-register-update/{{ $users->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="{{$users->name}}" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Give Role</label>
                                    <select name="usertype" class="form-control">
                                        <option value="admin" @if ($users->usertype === 'admin')
                                            selected
                                            @endif>Admin</option>
                                        <option value="user" @if ($users->usertype === 'user')
                                            selected
                                            @endif>User</option>
                                        <option value="">None</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>LoginType</label>
                                    <select name="logintype" class="form-control">
                                        <option value="1" @if ($users->logintype === 1)
                                            selected
                                            @endif>AD</option>
                                        <option value="0" @if ($users->logintype === 0)
                                            selected
                                            @endif>DB</option>
                                        <option value="">None</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="{{$users->username}}" name="username">
                                </div>

                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="/role-register" class="btn btn-danger">Cancel</a>
                                <a href="/role-reset/{{$users->id}}" class="btn btn-warning">Reset Password</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection