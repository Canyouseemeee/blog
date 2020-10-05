<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssuesCheckin extends Model
{
    protected $table ='issues_checkin';
    protected $primaryKey = 'Checkinid';
    protected $fillable = [
        'Issuesid','Status','Createby','Updateby','created_at','updated_at'
    ];
}
