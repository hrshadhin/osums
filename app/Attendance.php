<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
  use SoftDeletes;

  protected $dates = ['created_at','date'];
  protected $table = 'attendances';
  protected $fillable = [
    'session',
    'department_id',
    'students_id',
    'date',
    'subject_id',
    'levelTerm',
    'present',
  ];
  function setDateAttribute($value)
  {
    $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value);
  }

  public function student() {
    return $this->belongsTo('App\Student','students_id');
  }
}
