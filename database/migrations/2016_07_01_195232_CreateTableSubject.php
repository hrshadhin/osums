<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubject extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subject', function(Blueprint $table)
		{
      $table->increments('id');
			$table->string('name');
			$table->string('code',20)->unique;
			$table->string('credit',20);
			$table->string('description',250);
			$table->string('levelTerm',20);
			$table->timestamps();
			$table->softDeletes();
      $table->integer('department_id')->unsigned();
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
		Schema::drop('subject');
	}

}
