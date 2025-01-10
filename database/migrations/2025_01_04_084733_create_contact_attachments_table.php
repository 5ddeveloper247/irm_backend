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
        Schema::create('contact_attachments', function (Blueprint $table) {
            $table->id();
            // contact_reply_id
            $table->unsignedBigInteger('contact_reply_id');
            $table->foreign('contact_reply_id')->references('id')->on('contact_replies')->onDelete('cascade');
            $table->string('name', 255)->nullable();
            $table->string('path', 255)->nullable();
            $table->string('type', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_attachments');
    }
};
