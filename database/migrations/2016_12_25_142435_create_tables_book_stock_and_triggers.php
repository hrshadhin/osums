<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesBookStockAndTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('stock_books', function(Blueprint $table)
      {
        $table->unsignedInteger('books_id');
        $table->integer('quantity')->unsigned();
        $table->foreign('books_id')
              ->references('id')
              ->on('books');

      });
      //create tiggers for manage book stock
      //book addd trigger
      DB::unprepared('
      CREATE TRIGGER `afterBookAdd` AFTER INSERT ON `books` FOR EACH ROW
      BEGIN
      insert into stock_books
      set
      books_id = new.id,
      quantity = new.quantity;
      END
      ');
      //after book delete
      DB::unprepared('
      CREATE TRIGGER `afterBookDelete` AFTER DELETE ON `books` FOR EACH ROW
      BEGIN
      delete from borrow_books where books_id = old.id;
      delete from stock_books where books_id = old.id;
      END
      ');
      //afeter book update
      DB::unprepared('
      CREATE TRIGGER `afterBookUpdate` AFTER UPDATE ON `books` FOR EACH ROW
      BEGIN
      UPDATE stock_books
      set
      quantity = new.quantity-(old.quantity-quantity)
      WHERE books_id=old.id;
      END
      ');
      //after borrow book add
      DB::unprepared('
      CREATE TRIGGER `afterBorrowBookAdd` AFTER INSERT ON `borrow_books` FOR EACH ROW
      BEGIN
      UPDATE stock_books
      set quantity = quantity-new.quantity
      where books_id=new.books_id;
      END
      ');
      //after borrow book delete
      DB::unprepared("
      CREATE TRIGGER `afterBorrowBookDelete` AFTER DELETE ON `borrow_books` FOR EACH ROW
      IF (old.Status='Borrowed') THEN
      UPDATE stock_books
      set quantity = quantity+old.quantity
      WHERE books_id=old.books_id;
      END IF
      ");
      //after borrow book update
      DB::unprepared("
      CREATE TRIGGER `afterBorrowBookUpdate` AFTER UPDATE ON `borrow_books` FOR EACH ROW
      IF (new.Status='Returned') THEN
      UPDATE stock_books
      set quantity = quantity+new.quantity
      WHERE books_id=new.books_id;
      END IF
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stock_books');
        //drop tiggers
        DB::unprepared('DROP TRIGGER IF EXISTS afterBookAdd');
        DB::unprepared('DROP TRIGGER IF EXISTS afterBookDelete');
        DB::unprepared('DROP TRIGGER IF EXISTS afterBookUpdate');
        DB::unprepared('DROP TRIGGER IF EXISTS afterBorrowBookAdd');
        DB::unprepared("DROP TRIGGER IF EXISTS afterBorrowBookDelete");
        DB::unprepared("DROP TRIGGER IF EXISTS afterBorrowBookUpdate");

    }
}
