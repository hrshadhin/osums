<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
   use SoftDeletes;
   protected $dates = ['created_at','updated_at'];
   protected $table = 'registrations';
   protected $fillable = [
      'levelTerm',
      'department_id',
      'students_id',
      'session'
   ];

   public function department() {
      return $this->belongsTo('App\Department','department_id');
   }
   public function student() {
      return $this->belongsTo('App\Student','students_id');
   }
}
