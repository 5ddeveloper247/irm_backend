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
        Schema::create('menu_controls', function (Blueprint $table) {
            $table->id();
            // `user_id` int(10) UNSIGNED DEFAULT NULL,
            $table->unsignedBigInteger('user_id')->nullable();
            // `menu_id` int(10) UNSIGNED DEFAULT NULL,
            $table->unsignedBigInteger('menu_id')->nullable();
            // `created_by` int(10) UNSIGNED DEFAULT NULL,
            $table->unsignedBigInteger('created_by')->nullable();
            // `updated_by` int(10) UNSIGNED DEFAULT NULL,
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_controls');
    }
};
