<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Student extends Model {
  use SoftDeletes;
  protected $dates = ['created_at','dob'];
  protected $table = 'students';
  protected $fillable = [
    'idNo',
    'session',
    'department_id',
    'bncReg',
    'batchNo',
    'firstName',
    'middleName',
    'lastName',
    'mobileNo',
    'gender',
    'religion',
    'bloodgroup',
    'nationality',
    'dob',
    'photo',
    'fatherName',
    'fatherMobileNo',
    'motherName',
    'motherMobileNo',
    'localGuardian',
    'localGuardianMobileNo',
    'presentAddress',
    'parmanentAddress',
    'isActive'
  ];
  public static function boot()
  {
    parent::boot();
    static::deleting(function($student) {
      $student->registered()->delete();
      $student->attendance()->delete();
      $student->exams()->delete();
      $student->feeCollections()->delete();
    });
  }
  function setDobAttribute($value)
  {
    $this->attributes['dob'] = Carbon::createFromFormat('d/m/Y', $value);
  }
  public function department() {
    return $this->belongsTo('App\Department');
  }
  public function registered() {
    return $this->hasMany('App\Registration','students_id');
  }
  public function attendance() {
    return $this->hasMany('App\Attendance','students_id');
  }
  public function exams() {
    return $this->hasMany('App\Exam','students_id');
  }
  public function feeCollections() {
    return $this->hasMany('App\FeeCollection','students_id');
  }

}
