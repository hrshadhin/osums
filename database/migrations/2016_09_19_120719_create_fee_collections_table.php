<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeCollectionsTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('fee_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('students_id');
            $table->decimal('payableAmount',18,2);
            $table->decimal('lateFee',18,2)->default(0.00);
            $table->decimal('paidAmount',18,2);
            $table->decimal('dueAmount',18,2);
            $table->date('payDate');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('students_id')
            ->references('id')
            ->on('students');
        });
        //child table of fee collection
        Schema::create('fee_collection_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fee_collections_id');
            $table->string('name');
            $table->decimal('amount',6,2);
            $table->foreign('fee_collections_id')
            ->references('id')
            ->on('fee_collections');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('fee_collection_items');
        Schema::drop('fee_collections');
    }
}
