<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model {
  use SoftDeletes;
  protected $table = 'department';
  protected $fillable = ['name','code','credit','years','description'];
  public static function boot()
  {
    parent::boot();
    static::deleting(function($department) {
      $department->subjects()->delete();
      $department->books()->delete();
      $department->fees()->delete();
      foreach ($department->students()->get() as $student) {
            $student->feeCollections()->delete();
      }
      $department->students()->delete();
      $department->registered()->delete();
      $department->attendance()->delete();
      $department->exams()->delete();

    });
  }

  public function subjects()
  {
    return $this->hasMany('App\Subject','department_id');
  }
  public function students()
  {
    return $this->hasMany('App\Student','department_id');
  }
  public function registered() {
    return $this->hasMany('App\Registration','department_id');
  }
  public function attendance() {
    return $this->hasMany('App\Attendance','department_id');
  }
  public function exams() {
    return $this->hasMany('App\Exam','department_id');
  }
  public function fees() {
    return $this->hasMany('App\Fee','department_id');
  }
  public function books() {
    return $this->hasMany('App\Book','department_id');
  }

}
