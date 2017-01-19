<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DormitoryFee extends Model
{
  use SoftDeletes;

  protected $table = 'dormitory_fees';
  protected $dates = ['feeMonth'];
  protected $fillable = [
    'students_id',
    'feeMonth',
    'feeAmount'
  ];
  
  public function student() {
    return $this->belongsTo('App\Student');
  }
}
