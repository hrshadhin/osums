<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Account extends Model
{
   protected $table = 'accounts';
   protected $dates =['date'];
   protected $fillable = ['sectors_id','amount','date','description'];

   public function sector() {
      return $this->belongsTo('App\Sector','sectors_id');
   }
   function setDateAttribute($value)
   {
      $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value);
   }
}
