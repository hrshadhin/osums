<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDormitoryStudentsTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('dormitory_students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('students_id')->unsigned();
            $table->integer('dormitories_id')->unsigned();
            $table->date('joinDate');
            $table->date('leaveDate')->nullable();
            $table->string('roomNo',255);
            $table->decimal('monthlyFee',10,2);
            $table->string('isActive',3);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('dormitories_id')
            ->references('id')
            ->on('dormitories');
            $table->foreign('students_id')
            ->references('id')
            ->on('students');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('dormitory_students');
    }
}
