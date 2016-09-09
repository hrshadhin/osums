<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Sector extends Model {
 use SoftDeletes;

	protected $table = 'sectors';
	protected $fillable = ['name','type'];

   public function accounts() {
   return $this->hasMany('App\Account','sectors_id');
 }

}
