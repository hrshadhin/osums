<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Subject extends Model {
 use SoftDeletes;
	protected $table = 'subject';
	protected $fillable = ['name','code','credit','department_id','description','levelTerm'];

   public function department() {
   return $this->belongsTo('App\Department');
 }

}
