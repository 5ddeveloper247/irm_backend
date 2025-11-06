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
        Schema::table('facebook_tokens', function (Blueprint $table) {
            if (!Schema::hasColumn('facebook_tokens', 'last_refreshed_at')) {
                $table->timestamp('last_refreshed_at')->nullable()->after('token_type');
            }
            if (!Schema::hasColumn('facebook_tokens', 'refresh_count')) {
                $table->integer('refresh_count')->default(0)->after('last_refreshed_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facebook_tokens', function (Blueprint $table) {
            $table->dropColumn(['last_refreshed_at', 'refresh_count']);
        });
    }
};
