<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDormitoryFeesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('dormitory_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('students_id')->unsigned();
            $table->integer('dormitory_students_id')->unsigned();
            $table->date('feeMonth');
            $table->decimal('feeAmount',10,2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('students_id')
            ->references('id')
            ->on('students');
            $table->foreign('dormitory_students_id')
            ->references('id')
            ->on('dormitory_students');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('dormitory_fees');
    }
}
