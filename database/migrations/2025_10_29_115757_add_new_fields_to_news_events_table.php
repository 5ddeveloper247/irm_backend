<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToNewsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news_events', function (Blueprint $table) {
            // Remove event_time column if it exists
            if (Schema::hasColumn('news_events', 'event_time')) {
                $table->dropColumn('event_time');
            }
            
            // Add new columns
            $table->string('namaz_name')->nullable()->after('event_date');
            $table->string('monthly_subtype')->nullable()->after('recurring_type');
            $table->string('monthly_week')->nullable()->after('monthly_subtype');
            $table->string('yearly_subtype')->nullable()->after('monthly_week');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news_events', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['namaz_name', 'monthly_subtype', 'monthly_week', 'yearly_subtype']);
            
            // Add back event_time column
            $table->time('event_time')->nullable()->after('event_date');
        });
    }
}