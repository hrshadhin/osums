<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStudents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('idNo',20)->unique();
			$table->string('batchNo',20)->nullable();
			$table->string('session',15);
		  $table->integer('department_id')->unsigned();
			$table->string('bncReg',50);
			$table->string('firstName',60);
			$table->string('middleName',60);
			$table->string('lastName',60);
			$table->string('gender',10);
			$table->string('religion',15);
			$table->string('bloodgroup',10);
			$table->string('nationality',50);
			$table->date('dob');
			$table->string('photo',30);
			$table->string('mobileNo',15);


			$table->string('fatherName',180);
			$table->string('fatherMobileNo',15);
			$table->string('motherName',180);
			$table->string('motherMobileNo',15);
		  $table->string('localGuardian',180);
			$table->string('localGuardianMobileNo',15);
      $table->string('presentAddress',500);
			$table->string('parmanentAddress',500);
      $table->string('isActive',10)->defualt('Yes');
			$table->timestamps();
			$table->softDeletes();
      $table->foreign('department_id')
                   ->references('id')
                   ->on('department');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('students');
	}

}
