<html>
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

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            font-size: 18px;
        }

        table {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 3px;
            /* text-align: justify; */
            border: 1px solid black;
        }

        .la-1 {
            text-align: right;
        }

        .w-11p {
            width: 8em;
            word-wrap: break-word;
        }

        td.w-10p {
            width: 7em;
            word-wrap: break-word;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .left {
            float: left;
            /* text-align: center; */
        }

        @page {
            size: A4;
            padding: 15px;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="form-row ">
        <div class="form-group col-md-3">
            <b> <label>CNMI Support - Support </label>
                <label>#{{$Issues->Issuesid}}</label></b>
        </div>

        <b>
            <div class="form-group col-md-6">
                <label class="w-11p">{{$Issues->Subject}}</label>
            </div>
        </b>

        <div class="form-row ">
            <b> <label>วันที่แจ้ง : </label></b>
            <label>{{DateThai($Issues->created_at)}}</label>

            <b> <label>วันที่แก้ไขล่าสุด : </label></b>
            <label>{{DateThai($Issues->updated_at)}}</label>

            <b> <label>วันที่ปิดงาน : </label></b>
            @foreach($issueslog as $row6)
            @if($Issues->Statusid === 1 || $Issues->Statusid === 3)
            <label>ยังไม่ปิดงาน</label>
            @else
            <label>{{DateThai($row6->create_at)}}</label>
            @endif
            @endforeach

        </div>
        <br />
        <table class="table" width="100%">
            <tr valign="top">
                <td>
                    <div class="">
                        <b><label class="left">Tracker : </label></b>
                        @foreach($trackname as $row)
                        @if ($row->Trackerid === $Issues->Trackerid)
                        <label class="center">{{$row->TrackName}}</label>
                        @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <b><label class="left">SubTrackName : </label></b>
                        @foreach($trackname as $row)
                        @if ($row->Trackerid === $Issues->Trackerid)
                        <label class="center">{{$row->SubTrackName}}</label>
                        @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <b><label class="left">TrackName : </label></b>
                        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                        @foreach($trackname as $row)
                        @if ($row->Trackerid === $Issues->Trackerid)
                        <label class="center">{{$row->Name}}</label>
                        @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <b><label class="left">Priority : </label></b>
                        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                        @foreach($issuespriority as $row2)
                        @if ($row2->Priorityid === $Issues->Priorityid)
                        <label class="center">{{$row2->ISPName}}</label>
                        @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <b><label class="left">Status : </label></b>
                        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                        @foreach($issuesstatus as $row3)
                        @if ($row3->Statusid === $Issues->Statusid)
                        <label class="center">{{$row3->ISSName}}</label>
                        @endif
                        @endforeach
                    </div>
                </td>
                <td>
                    <div class="row">
                        <b><label class="left">Department : </label></b>
                        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp; -->
                        @foreach($department as $row4)
                        @if ($row4->Departmentid === $Issues->Departmentid)
                        <label class="center">{{$row4->DmName}}</label>
                        @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <b> <label class="left">Createby : </label></b>
                        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                        <label class="center">{{$Issues->Createby}}</label>
                    </div>
                    <div class="row">
                        <b> <label class="left">Updatedby : </label></b>
                        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                        <label class="center">{{$Issues->Updatedby}}</label>
                    </div>
                    <div class="row">
                        <b> <label class="left">Closedby : </label></b>
                        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                        @if($Issues->Statusid === 1 || $Issues->Statusid === 3)
                        <label class="center">ยังไม่ปิดงาน</label>
                        @else
                        <label class="center">{{$Issues->Closedby}}</label>
                        @endif
                    </div>
                    <div class="row">
                        <b><label class="left">Assignment : </label></b>
                        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                        @foreach($user as $row5)
                        @if ($row5->id === $Issues->Assignment)
                        <label class="center">{{$row5->name}}</label>
                        @endif
                        @endforeach
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <td colspan="2">
                    <div class="row">
                        <b><label>Tel : </label></b>
                        <label class="w-11p">{{$Issues->Tel}}</label>
                    </div>
                    <div class="row">
                        <b><label>Comname : </label></b>
                        <label class="w-11p">{{$Issues->Comname}}</label>
                    </div>
                    <div class="row">
                        <b><label>Informer : </label></b>
                        <label class="w-11p">{{$Issues->Informer}}</label>
                    </div>
                    <div class="row">
                        <b><label>Description : </label></b>
                        <label class="w-11p">{{$Issues->Description}}</label>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>