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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('author_name')->nullable();
            $table->string('title')->nullable();
            $table->string('tags')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->date('published_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('status')->nullable()->default('1')->comment('0:inactive, 1:active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
