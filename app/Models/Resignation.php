<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Resignation extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'emirates_id',
        'guard_name',
        'company_name',
        'reason',
        'branch',
        'resignation_date',
    ];

}
