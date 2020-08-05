@extends('layouts.master2')

@section('title')
Web Test
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Priority
                    <a href="{{ url('priority-create') }}" class="btn btn-primary float-right">Add</a>
                </h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="text-primary">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </thead>
                    <tbody>
                        @foreach($issuespriority as $row)
                        <tr>
                            <input type="hidden" class="prioritydelete_val" value="{{$row->Priorityid}}">
                            <td>{{$row->Priorityid}}</td>
                            <td>{{$row->ISPName}}</td>
                            <td>
                                <div style="height: 30px; overflow: hidden;">
                                    {{$row->Description}}
                                </div>
                            </td>
                            <td>
                                <a href="{{ url('priority-edit/'.$row->Priorityid) }}" class="btn btn-success">EDIT</a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger prioritydeletebtn">DELETE</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // $('#datatable').DataTable();

        $('.prioritydeletebtn').click(function(e) {
            e.preventDefault();
            var delete_id = $(this).closest('tr')
                .find('.prioritydelete_val').val();

            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var data = {
                            "_token": $('input[name="_token"]').val(),
                            "id": delete_id,
                        };

                        $.ajax({
                            type: "DELETE",
                            url: '/priority-delete/' + delete_id,
                            data: data,
                            success: function(response) {
                                swal(response.status, {
                                    icon: "success",
                                }).then((result) => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
        });
    });
</script>
@endsection