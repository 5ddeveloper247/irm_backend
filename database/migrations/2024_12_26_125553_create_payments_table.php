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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // clientSecret
            $table->string('client_secret')->nullable();
            // json field nullable
            $table->json('data')->nullable();
            // task_id
            $table->string('task_id')->nullable();
            // compaign_id
            $table->integer('compaign_id')->nullable();
            // ammount
            $table->decimal('amount',8,2)->nullable()->default('0');
            // status
            $table->string('status')->nullable();
            // payment_intent
            $table->string('payment_intent')->nullable();
            // module_code
            $table->string('module_code')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
