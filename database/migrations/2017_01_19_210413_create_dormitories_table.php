<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDormitoriesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('dormitories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->integer('numOfRoom')->defualt(0);
            $table->string('address',255);
            $table->text('description');
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
        Schema::drop('dormitories');
    }
}
