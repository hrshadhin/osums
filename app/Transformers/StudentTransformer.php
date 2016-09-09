<?php

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Registration;

class StudentTransformer extends TransformerAbstract
{
  /**
  * @param \App\Registration $students
  *
  * @return array
  */
  public function transform(Registration $students)
  {
    return [

      'id' => (int)$students->student->id,
      'idNo' => $students->student->idNo,
      'name' => $students->student->firstName.' '.$students->student->middleName.' '.$students->student->lastName,
    ];
  }
}
