<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('levelTerm',20);
            $table->string('session',15);
            $table->unsignedInteger('students_id');
            $table->integer('department_id')->unsigned();
            $table->foreign('students_id')
                         ->references('id')
                         ->on('students');
            $table->foreign('department_id')
                         ->references('id')
                         ->on('department');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('registrations');
    }
}
