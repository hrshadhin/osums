<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class DormitoryFee extends Model
{
  use SoftDeletes;

  protected $table = 'dormitory_fees';
  protected $dates = ['feeMonth'];
  protected $fillable = [
    'students_id',
    'dormitory_students_id',
    'feeMonth',
    'feeAmount'
  ];

  public function student() {
    return $this->belongsTo('App\Student','students_id');
  }
  public function dormitoryStudent() {
    return $this->belongsTo('App\DormitoryStudent','dormitory_students_id');
  }
  function setFeeMonthAttribute($value)
  {
    $this->attributes['feeMonth'] = Carbon::createFromFormat('Y-m', $value);
  }
}
