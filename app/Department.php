<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model {
	use SoftDeletes;
	protected $table = 'department';
	protected $fillable = ['name','code','credit','years','description'];

	public function subjects()
  {
      return $this->hasMany('App\Subject','department_id');
  }
	public function students()
  {
 		 return $this->hasMany('App\Student','department_id');
  }
  public function registered() {
   return $this->hasMany('App\Registration','department_id');
 }
}
