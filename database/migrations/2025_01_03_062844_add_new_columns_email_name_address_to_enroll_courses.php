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
        Schema::table('enroll_courses', function (Blueprint $table) {
            //address
            $table->string('address')->nullable();
            //email
            $table->string('email')->nullable();
            // name
            $table->string('name')->nullable();
            // phone
            $table->string('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enroll_courses', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('email');
            $table->dropColumn('name');
            $table->dropColumn('phone');
        });
    }
};
