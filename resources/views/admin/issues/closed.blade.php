@extends('layouts.master')

@section('title')
Web Test
@endsection

@section('content')
<?php

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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ url('issues-filter-closed') }}" method="post">
                {{ csrf_field() }}
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">{{ __('Filter') }}</div>
                                <div class="card-body row ">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right"> Fromdate : </label>
                                        <div class="col-md-8">
                                            <input type="date" name="fromdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right"> Todate : </label>
                                        <div class="col-md-8">
                                            <input type="date" name="todate" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-info float-right">Search</button>
                                        <a href="#" class="btn btn-danger float-right">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card-header">
                <h4 class="card-title"> Closed Issues
                    <a href="{{ url('issues-create') }}" class="btn btn-success float-right">Add Issues</a>
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
                                        <a href="{{ url('issues-show/'.$row->Issuesid) }}">{{$row->Subject}}</a>
                                    </div>
                                </td>
                                <td>{{DateThai($row->updated_at)}}</td>
                                <td>
                                    <a href="{{ url('issues-show/'.$row->Issuesid) }}" class="btn btn-success">View</a>
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
                                        <a href="{{ url('issues-show/'.$betweens->Issuesid) }}">{{$betweens->Subject}}</a>
                                    </div>
                                </td>
                                <td style="text-align:center">{{DateThai($betweens->updated_at)}}</td>
                                <td>
                                    <a href="{{ url('issues-show/'.$betweens->Issuesid) }}" class="btn btn-success">View</a>
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