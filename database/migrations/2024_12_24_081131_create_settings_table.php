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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            // company_logo
            $table->string('company_logo')->nullable();
            // company_address
            $table->string('company_address');
            // company_phone
            $table->string('company_phone')->nullable();
            // company_email
            $table->string('company_email')->nullable();
            // company_website
            $table->string('company_website')->nullable();
            // facebook_link
            $table->string('facebook_link')->nullable();
            // twitter_link
            $table->string('twitter_link')->nullable();
            // instagram_link
            $table->string('instagram_link')->nullable();
            // linkedin_link
            $table->string('linkedin_link')->nullable();
            // youtube_link
            $table->string('youtube_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
