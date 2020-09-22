@extends('layouts.master')

@section('title')
Register
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">UserManagement <a href="{{ url('create-user') }}" class="btn btn-primary float-right">Add User</a></h4>
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead class="text-primary">
                            <th>Name</th>
                            <th>Username</th>
                            <th>Logintype</th>
                            <th>Usertype</th>
                            <th>EDIT</th>
                            <th>Active</th>
                        </thead>
                        <tbody>
                            @foreach($users as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>{{$row->username}}</td>
                                @if($row->logintype === 1)
                                <td>AD</td>
                                @elseif($row->logintype === 0)
                                <td>DB</td>
                                @endif
                                <td>{{$row->usertype}}</td>
                                <td>
                                    <a href="/role-edit/{{$row->id}}" class="btn btn-success">EDIT</a>
                                </td>
                                <td><input type="checkbox" class="toggle-class" data-id="{{$row->id}}" data-toggle="toggle" data-on="Enabled" data-off="Disabled" {{$row->active==true ? 'checked':''}}></td>
                                <td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>

<script>
  $(function() {
    $('#toggle-two').bootstrapToggle({
      on: 'Enabled',
      off: 'Disabled',
      onstyle: 'primary'
    });
  });

  $('.toggle-class').on('change',function(){
    var active=$(this).prop('checked')==true ? 1:0;
    var id=$(this).data('id');
    // alert(id);
    $.ajax({
        type:'GET',
        dataType:'json',
        url:'{{route("change_active")}}',
        data:{'active':active,'id':id},
        success:function(data){
            $('.message').html('<p class="alert alert-danger">'+data.success+'</p>');
        }
    });
  });
</script>
@endsection