<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE news_events CHANGE owner_name organizer_name VARCHAR(255) NULL;");
    }

    public function down()
    {
        DB::statement("ALTER TABLE news_events CHANGE organizer_name owner_name VARCHAR(255) NULL;");
    }
};
