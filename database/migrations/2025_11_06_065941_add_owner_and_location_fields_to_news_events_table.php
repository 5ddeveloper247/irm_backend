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
        Schema::table('news_events', function (Blueprint $table) {
            $table->string('owner_name')->nullable()->after('namaz_name');
            $table->string('organization_no')->nullable()->after('owner_name');
            $table->string('country')->nullable()->after('organization_no');
            $table->string('city')->nullable()->after('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_events', function (Blueprint $table) {
            $table->dropColumn(['owner_name', 'organization_no', 'country', 'city']);
        });
    }
};