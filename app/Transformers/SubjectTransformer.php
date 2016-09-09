<?php

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Subject;

class SubjectTransformer extends TransformerAbstract
{
  /**
  * @param \App\Subject $subjects
  *
  * @return array
  */
  public function transform(Subject $subjects)
  {
    return [

      'id' => (int)$subjects->id,
      'code' => $subjects->code,
      'name' => $subjects->name,
    ];
  }
}
