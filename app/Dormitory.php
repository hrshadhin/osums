<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dormitory extends Model
{
  use SoftDeletes;

  protected $table = 'dormitories';
  protected $fillable = [
    'name',
    'numOfRoom',
    'address',
    'description'

  ];

  public function students() {
    return $this->hasMany('App\DormitoryStudent');
  }
}
