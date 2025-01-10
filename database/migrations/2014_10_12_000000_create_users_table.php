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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->nullable;
            $table->string('email')->unique();
            $table->tinyInteger('role')->nullable()->comment('1:superadmin, 2:customer, 3:sub-admin');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('otp', 10)->nullable();
            $table->tinyInteger('status')->nullable()->default('1')->comment('0:inactive, 1:active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
