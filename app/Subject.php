<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Subject extends Model {
   use SoftDeletes;
   protected $table = 'subject';
   protected $fillable = ['name','code','credit','department_id','description','levelTerm'];

   public static function boot()
   {
      parent::boot();
      static::deleting(function($subject) {
         $subject->attendance()->delete();
         $subject->exams()->delete();
      });
   }
   public function department() {
      return $this->belongsTo('App\Department');
   }
   public function attendance() {
      return $this->hasMany('App\Attendance','subject_id');
   }
   public function exams() {
      return $this->hasMany('App\Exam','subject_id');
   }

}
