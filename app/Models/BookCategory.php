<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $table="book_category";
    use HasFactory;
    // books
    public function books()
    {
        return $this->hasMany('App\Models\BookLibrary','book_category_id');
    }
    public function getTitleAttribute($value)
    {
        return ucwords($value);
    }
}
