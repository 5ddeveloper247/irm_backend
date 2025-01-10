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
        Schema::create('work_locations', function (Blueprint $table) {
            $table->id();
            // name
            $table->string('title');
            // lat
            $table->double('lat', 15, 8);
            // lng
            $table->double('lng', 15, 8);
            // color
            $table->string('color')->nullable();
            // descriptions
            $table->text('descriptions')->nullable();
            // status 1,0
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_locations');
    }
};
