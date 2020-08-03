@extends('layouts.master')

@section('title')
Web Test
@endsection

@section('content')
<?php

use Carbon\Carbon;

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate)) + 7;
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear $strHour:$strMinute น.";
}
?>

<!-- Delete Modal -->
<div class="modal fade" id="deletemodalpop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">DELETE FORM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_modal_Form" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="modal-body">
                    <input type="hidden" id="delete_aboutus_id">
                    <h5>Are you sure.? you want to delete this Data</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Yes. Delete It.</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ url('issues-filter-news') }}" method="post">
                {{ csrf_field() }}
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">{{ __('Filter') }}</div>
                                <div class="card-body row">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right"> Fromdate </label>
                                        <div class="col-md-8">
                                            <input type="date" name="fromdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right"> Todate </label>
                                        <div class="col-md-8">
                                            <input type="date" name="todate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 " align="center">
                                            <button type="submit" class="btn btn-info">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card-header">
                <h4 class="card-title"> New Issues
                    <a href="{{ url('issues-create') }}" class="btn btn-primary float-right">Add Issues</a>
                </h4>
            </div>
            <style>
                .w-10p {
                    width: 10% !important;
                }

                .w-11p {
                    width: 300px;
                    word-break: 'break-all';
                }
            </style>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead class="text-primary">
                            <th class="w-10p">Id</th>
                            <th class="w-10p">Tracker</th>
                            <th class="w-10p">Status</th>
                            <th class="w-10p">Priority</th>
                            <th class="w-10p">Users</th>
                            <th class="w-10p">Subject</th>
                            <th class="w-10p">Created</th>
                            <th class="w-10p">Updated</th>
                            <th class="w-10p">Views</th>
                        </thead>
                        @if (!is_null($issues))
                        <tbody>
                            @foreach($issues as $row)
                            <tr>
                                <td>{{$row->Issuesid}}</td>
                                <td>{{$row->ISTName}}</td>
                                <td>{{$row->ISSName}}</td>
                                <td>{{$row->ISPName}}</td>
                                <td>{{$row->Users}}</td>
                                <td>
                                    <div class="w-11p" style="height: 30px; overflow: hidden;">
                                        {{$row->Subject}}
                                    </div>
                                </td>
                                <td>{{DateThai($row->created_at)}}</td>
                                <td>{{DateThai($row->updated_at)}}</td>
                                <td>
                                    <a href="#" class="btn btn-success">View</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            @if (!is_null($between))
                            @foreach ($between as $betweens)
                            <tr>
                                <th scope="row">{{$betweens->Issuesid}}</th>
                                <td style="text-align:center">{{$betweens->ISTName}}</td>
                                <td style="text-align:center">{{$betweens->ISSName}}</td>
                                <td style="text-align:center">{{$betweens->ISPName}}</td>
                                <td style="text-align:center">{{$betweens->Users}}</td>
                                <td>
                                    <div class="w-11p" style="height: 30px; overflow: hidden;">
                                        <a href="#">{{$betweens->Subject}}</a>
                                    </div>
                                </td>
                                <td style="text-align:center">{{DateThai($betweens->created_at)}}</td>
                                <td style="text-align:center">{{DateThai($betweens->updated_at)}}</td>
                                <td>
                                    <a href="#" class="btn btn-success">View</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
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

        $('#datatable').on('click', '.deletebtn', function() {
            $tr = $(this).closest('tr');

            var data = $tr.children('td').map(function() {
                return $(this).text();
            }).get();

            // console.log(data);

            $('#delete_aboutus_id').val(data[0]);

            $('#delete_modal_Form').attr('action', '/about-us-delete/' + data[0]);

            $('#deletemodalpop').modal('show');
        });
    });
</script>
@endsection