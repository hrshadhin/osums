<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowBooksTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('borrow_books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('students_id');
            $table->unsignedInteger('books_id');
            $table->integer('quantity')->unsigned();
            $table->date('issueDate');
            $table->date('returnDate');
            $table->decimal('fine',18,2)->default(0.00);
            $table->string('Status',10)->default('Borrowed');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('books_id')
            ->references('id')
            ->on('books');
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
        Schema::drop('borrow_books');
    }
}
