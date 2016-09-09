<?php

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Attendance;

class AttendanceTransformer extends TransformerAbstract
{
  /**
  * @param \App\Attendance $attendance
  *
  * @return array
  */
  public function transform(Attendance $attendance)
  {

    return [
      'id' => (int)$attendance->id,
      'idNo' => $attendance->student->idNo,
      'name' => $attendance->student->firstName.' '.$attendance->student->middleName.' '.$attendance->student->lastName,
      'present' => $attendance->present,
    ];
  }
}
