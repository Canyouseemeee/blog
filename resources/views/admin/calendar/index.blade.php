@extends('layouts.master')


@section('content')
<?php

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear $strHour:$strMinute น.";
}
?>

<!-- <h3>Calendar</h3> -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-3 ">
                <h4 class="card-title"> Calendar</h4>
            </div>

            <div class="card-body">
                <div id='calendar'></div>

            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            events: [
                @foreach($appointments as $appointment) {
                    title: 'Issuesid : {{$appointment->Issuesid}}',
                    start: '{{$appointment->Date}}',
                    url : "{{ url('issues-show/'. $appointment->Issuesid) }}"
                },
                @endforeach
            ],
        })
    });
</script>
@endsection