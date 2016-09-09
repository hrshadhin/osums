<?php

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Exam;

class MarksTransformer extends TransformerAbstract
{
  /**
  * @param \App\Exam $marks
  *
  * @return array
  */
  public function transform(Exam $marks)
  {

    return [
      'id' => (int)$marks->id,
      'idNo' => $marks->student->idNo,
      'name' => $marks->student->firstName.' '.$marks->student->middleName.' '.$marks->student->lastName,
      'raw_score' => $marks->raw_score,
      'percentage' => $marks->percentage,
      'weight' => $marks->weight,
      'percentage_x_weight' => $marks->percentage_x_weight,
    ];
  }
}
