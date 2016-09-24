<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class FeeCollection extends Model
{
    use SoftDeletes;
    protected $table = 'fee_collections';
    protected $fillable = [
        'students_id',
        'payableAmount',
        'lateFee',
        'paidAmount',
        'dueAmount',
        'payDate'
    ];
    protected $dates = ['created_at','payDate'];
    function setpayDateAttribute($value)
    {
        $this->attributes['payDate'] = Carbon::createFromFormat('d/m/Y', $value);
    }

}
