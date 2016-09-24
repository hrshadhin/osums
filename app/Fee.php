<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use SoftDeletes;
    protected $table = 'fees';
    protected $fillable = ['title','amount', 'description', 'department_id'];

    public function department() {
        return $this->belongsTo('App\Department','department_id');
    }

}
