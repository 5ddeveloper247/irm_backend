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
        Schema::create('news_events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('type')->nullable();
            $table->string('recurring_type')->nullable();
            $table->string('repeat_on', 255)->nullable();
            $table->string('location')->nullable();
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
        Schema::dropIfExists('news_events');
    }
};
