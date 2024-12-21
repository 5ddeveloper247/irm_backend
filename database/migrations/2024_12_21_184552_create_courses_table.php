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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('instructor_name')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->integer('total_lectures')->nullable();
            $table->string('level')->nullable();
            $table->string('language')->nullable();
            $table->string('certificate', 10)->nullable();
            $table->date('date')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->tinyInteger('status')->nullable()->default('1')->comment('0:inactive, 1:active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
