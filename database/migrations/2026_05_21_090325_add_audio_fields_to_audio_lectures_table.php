<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audio_lectures', function (Blueprint $table) {
            $table->string('speaker', 150)->nullable()->after('title');
            $table->string('audio_source_type', 20)->default('file')->after('duration');
            $table->text('embed_url')->nullable()->after('audio_source_type');
            $table->string('external_url', 500)->nullable()->after('embed_url');
        });
    }

    public function down(): void
    {
        Schema::table('audio_lectures', function (Blueprint $table) {
            $table->dropColumn(['speaker', 'audio_source_type', 'embed_url', 'external_url']);
        });
    }
};
