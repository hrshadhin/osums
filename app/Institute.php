<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model {
	protected $table = 'institute';
	protected $fillable = ['name','establish','name','email','web','phoneNo','address'];
}
