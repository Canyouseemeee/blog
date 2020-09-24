<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FilterExport implements FromCollection,WithHeadings, ShouldAutoSize
{
    public $fromdate;
    public $todate;


    public function __construct($fromdate,$todate)
    {
        $this->fromdate = $fromdate;
        $this->todate = $todate;
        
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('issues')->select(
            'issues.created_at',
            'issues_tracker.TrackName',
            'issues_tracker.SubTrackName',
            'issues_tracker.Name',
            'issues_status.ISSName',
            'issues_priority.ISPName',
            'issues.Subject',
            'issues.Description',
            'department.DmName',
            'issues.Tel',
            'issues.Comname',
            'issues.Informer',
            'users.name',
            'issues.Createby',
            'issues.Closedby',
            'issues_logs.create_at',
        )
            ->join('issues_tracker', 'issues.Trackerid', '=', 'issues_tracker.Trackerid')
            ->join('issues_priority', 'issues.Priorityid', '=', 'issues_priority.Priorityid')
            ->join('issues_status', 'issues.Statusid', '=', 'issues_status.Statusid')
            ->join('department', 'issues.Departmentid', '=', 'department.Departmentid')
            ->join('issues_logs', 'issues.Issuesid', '=', 'issues_logs.Issuesid')
            ->join('users', 'issues.Assignment', '=', 'users.id')
            ->where('Action', 'Closed')
            ->whereBetween('issues.Date_In', [$this->fromdate, $this->todate])
            ->get();
    }

    public function headings(): array
    {
        return [
            'วันที่แจ้งงาน',
            'Tracker(ประเภทงาน)',
            'SubTracker(ประเภท)',
            'SubName(งาน)',
            'Status(สถานะ)',
            'Priority(ระดับความสำคัญ)',
            'Subject(หัวเรื่อง)',
            'Description(รายละเอียด)',
            'Department(แผนก)',
            'Tel(เบอร์แผนก)',
            'Comname',
            'Informer(รหัสพนักงาน)',
            'Assignment(หมอบหมายงาน)',
            'คนที่เปิดงาน',
            'คนที่ปิดงาน',
            'วันที่ปิดงาน',
        ];
    }
}
