<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $table = 'books';
    protected $fillable = [
        'code',
        'title',
        'author',
        'rackNo',
        'rowNo',
        'type',
        'desc',
        'department_id'
    ];

    public function stock() {
        return $this->hasOne('App\StockBook','books_id');
    }
    public function borrow() {
        return $this->hasMany('App\BorrowBook');
    }
    public function department() {
        return $this->belongsTo('App\Department');
    }
}
