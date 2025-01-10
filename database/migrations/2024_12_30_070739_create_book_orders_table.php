<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_orders', function (Blueprint $table) {
            $table->id();
            // payment_id forgien key
            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            // book_id forgien key
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books_library')->onDelete('cascade');
            // status 1=pendding, 2=shipped, 3=delivered, 4=completed
            $table->tinyInteger('status')->nullable()->default('1')->comment('1:pendding, 2:shipped, 3:delivered, 4:completed');
            // json data
            $table->json('data')->nullable();
            // amount
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_orders');
    }
};
