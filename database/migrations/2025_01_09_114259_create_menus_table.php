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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            // `seq_no` smallint(6) DEFAULT NULL,
            $table->smallInteger('seq_no')->nullable();
            // `name` varchar(100) DEFAULT NULL,
            $table->string('name', 100)->nullable();
            // `route` varchar(255) DEFAULT NULL,
            $table->string('route', 255)->nullable();
            // `image` varchar(255) DEFAULT NULL,
            $table->string('image', 255)->nullable();
            // `enable` smallint(6) NOT NULL DEFAULT 1,
            $table->smallInteger('enable')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
