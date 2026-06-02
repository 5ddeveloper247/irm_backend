<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLibrary extends Model
{
    use HasFactory;

    protected $table = 'books_library';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'book',
        'book_name',
        'price',
        'currency',
        'delivery_charge_local',
        'delivery_charge_international',
        'date',
        'status',
        'book_category_id',
        'book_homepage',
    ];

    public function bookorders()
    {
        return $this->hasMany(BookOrder::class, 'book_id');
    }

    public function getTitleAttribute($value)
    {
        return ucwords($value);
    }

    public function bookcategory()
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }
}
