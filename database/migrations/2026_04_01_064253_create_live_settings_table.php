<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_settings', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->default('youtube'); // 'youtube' or 'facebook'
            $table->string('live_url')->nullable();
            $table->tinyInteger('is_active')->default(0); // 0 = inactive, 1 = active
            $table->timestamps();
        });

        // Insert a default empty row so we always have one record (like settings table)
        DB::table('live_settings')->insert([
            'platform'   => 'youtube',
            'live_url'   => null,
            'is_active'  => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('live_settings');
    }
};