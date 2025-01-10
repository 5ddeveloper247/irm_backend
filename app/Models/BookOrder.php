<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;
use App\Models\BookLibrary;
class BookOrder extends Model
{
    use HasFactory;
    protected $table = 'book_orders';
    // get payment details with book order
    public function payment()
    {
        return $this->belongsTo('App\Models\Payment','payment_id');
    }
    // get book details with book order
    public function book()
    {
        return $this->belongsTo('App\Models\BookLibrary','book_id');
    }

}
