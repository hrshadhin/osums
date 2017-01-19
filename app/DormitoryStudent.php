<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

  public function dormitory() {
    return $this->belongsTo('App\Dormitory');
  }
  public function student() {
    return $this->belongsTo('App\Student');
  }
}
