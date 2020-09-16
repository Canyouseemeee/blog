<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MacAddress extends Model
{
    protected $table ='deviceinfo';
    protected $primaryKey = 'deviceinfoid';
    protected $fillable = [
        'deviceid','created_at','updated_at'
    ];
}
