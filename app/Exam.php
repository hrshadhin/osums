<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $dates = ['created_at'];
    protected $table = 'exams';
    protected $fillable = [
        'department_id',
        'session',
        'levelTerm',
        'subject_id',
        'students_id',
        'exam',
        'raw_score',
        'percentage',
        'weight',
        'percentage_x_weight',
    ];

    public function subject() {
        return $this->belongsTo('App\Subject','subject_id');
    }
    public function student() {
        return $this->belongsTo('App\Student','students_id');
    }
}
