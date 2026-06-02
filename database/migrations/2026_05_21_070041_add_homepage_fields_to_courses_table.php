<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->tinyInteger('course_homepage')->default(0)->after('status');
            $table->string('homepage_section_title', 150)->nullable()->after('course_homepage');
            $table->tinyInteger('enroll_enabled')->default(1)->after('homepage_section_title');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['course_homepage', 'homepage_section_title', 'enroll_enabled']);
        });
    }
};
