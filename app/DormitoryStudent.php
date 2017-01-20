<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class DormitoryStudent extends Model
{
  use SoftDeletes;

  protected $table = 'dormitory_students';
  protected $dates = ['joinDate','leaveDate'];
  protected $fillable = [
    'students_id',
    'dormitories_id',
    'joinDate',
    'leaveDate',
    'roomNo',
    'monthlyFee',
    'isActive',
  ];
  function setJoinDateAttribute($value)
  {
    $this->attributes['joinDate'] = Carbon::createFromFormat('d/m/Y', $value);
  }
  function setLeaveDateAttribute($value)
  {
    $this->attributes['leaveDate'] = Carbon::createFromFormat('d/m/Y', $value);
  }
  public function dormitory() {
    return $this->belongsTo('App\Dormitory','dormitories_id');
  }
  public function student() {
    return $this->belongsTo('App\Student','students_id');
  }
  public function fee() {
    return $this->hasMany('App\DormitoryFee','dormitory_students_id');
  }

}
