<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('session',15);
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('students_id');
            $table->unsignedInteger('department_id');
            $table->string('levelTerm',20);
            $table->tinyInteger('present')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('subject_id')
                         ->references('id')
                         ->on('subject');
            $table->foreign('students_id')
                         ->references('id')
                         ->on('students');
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
        Schema::drop('attendances');
    }
}
