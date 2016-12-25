<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowBook extends Model
{
  use SoftDeletes;

    protected $table = 'borrow_books';
    protected $dates = ['issueDate','returnDate'];
    protected $fillable = [
        'students_id',
        'books_id',
        'quantity',
        'issueDate',
        'returnDate',
        'fine',
        'status'
        ];

    public function book() {
        return $this->belongsTo('App\Book');
    }
}
