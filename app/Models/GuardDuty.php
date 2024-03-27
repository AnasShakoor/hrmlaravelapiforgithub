<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuardDuty extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'emirates_id',
        'guard',
        'company',
        'time_policy',
        'date_joining',
        'duty_start_time',
        'key',
        'wireless',
        'uniform',
        'shoes',
        'weapan',
        'others',
        'file',
        'notes',
        'guard_id',
    ];

    public function guards()
    {
        return $this->belongsTo(Guard::class);
    }
}
