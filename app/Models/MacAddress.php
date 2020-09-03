<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MacAddress extends Model
{
    protected $table ='mac_address';
    protected $primaryKey = 'Macid';
    protected $fillable = [
        'MacAddress','created_at','updated_at'
    ];
}
