<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockBook extends Model
{
  protected $table = 'stock_books';
  protected $fillable = [
    'books_id',
    'quantity',
  ];
  public function book() {
    return $this->belongsTo('App\Book');
  }
}
