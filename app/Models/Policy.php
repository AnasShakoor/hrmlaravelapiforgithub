<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Policy extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'late_allow',
        'early_allow',
        'deduction',
    ];
}
