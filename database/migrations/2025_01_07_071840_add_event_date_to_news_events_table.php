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
            $table->date('event_date')->nullable()->after('description'); // Replace 'column_name' with the column after which you want to add 'event_date'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_events', function (Blueprint $table) {
            $table->dropColumn('event_date');
        });
    }
};
