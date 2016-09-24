<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->decimal('amount',6,2);
            $table->text('description')->nullable();
            $table->unsignedInteger('department_id');
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
        Schema::drop('fees');
    }
}
