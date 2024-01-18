<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Guard extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'phone_number',
        'date',
        'company',
        'country',
        'photo',
        'passport',
        'emirates_id_number',
        'emirates_id_photo',
        'resume',
        'acount_holder_name',
        'acount_number',
        'bank_number',
        'branch_name',
        'location',
        'tax_payer_id',
        'user_id',
        'company_id'

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function guardsduty()
    {
        return $this->hasOne(GuardDuty::class);
    }
}
