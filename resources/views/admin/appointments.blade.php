<!-- {{$data}} -->
<table id="datatableappoint" class="table">
    <thead class="text-primary">
        <th>Date</th>
        <th>Comment</th>
        <th>Status</th>
        <th>Createby</th>
        <th>Updateby</th>
        <th>Created_at</th>
        <th>Updated_at</th>
        <th>Edit</th>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{$row->Date}}</td>
            <td>
                <div class="w-11p" style="height: 30px; overflow: hidden;">
                    {{$row->Comment}}
                </div>
            </td>
            @if($row->Status === 1)
            <td>Active</td>
            @elseif($row->Status === 2)
            <td>Change</td>
            @elseif($row->Status === 3)
            <td>Disable</td>
            @endif
            <td>{{$row->Createby}}</td>
            <td>{{$row->Updateby}}</td>
            <td>{{$row->created_at}}</td>
            <td>{{$row->updated_at}}</td>
            @if($row->Status === 1)
            <td>
                <a href="" data-toggle="modal" data-target="#issueseditModal{{$row->Appointmentsid}}" class="btn btn-success">Edit</a>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>