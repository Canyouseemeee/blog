@extends('layouts.master2')

@section('title')
Web Test
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Tracker
                    <a href="{{ url('tracker-create') }}" class="btn btn-primary float-right">Add</a>
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
                        @foreach($issuestracker as $row)
                        <tr>
                            <input type="hidden" class="trackerdelete_val" value="{{$row->Trackerid}}">
                            <td>{{$row->Trackerid}}</td>
                            <td>{{$row->ISTName}}</td>
                            <td>
                                <div style="height: 30px; overflow: hidden;">
                                    {{$row->Description}}
                                </div>
                            </td>
                            <td>
                                <a href="{{ url('tracker-edit/'.$row->Trackerid) }}" class="btn btn-success">EDIT</a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger trackerdeletebtn">DELETE</button>
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

        $('.trackerdeletebtn').click(function(e) {
            e.preventDefault();
            var delete_id = $(this).closest('tr')
                .find('.trackerdelete_val').val();

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
                            url: '/tracker-delete/' + delete_id,
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