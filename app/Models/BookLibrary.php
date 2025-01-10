<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLibrary extends Model
{
    use HasFactory;

    protected $table="books_library";
    // get book orders list with payment and book name and get total payemnt sum and count
    public function bookorders()
    {
        return $this->hasMany('App\Models\BookOrder','book_id');
    }
    public function getTitleAttribute($value)
    {
        return ucwords($value);
    }
    
}
