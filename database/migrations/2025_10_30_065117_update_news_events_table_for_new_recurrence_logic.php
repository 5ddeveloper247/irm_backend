<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNewsEventsTableForNewRecurrenceLogic extends Migration
{
    public function up()
    {
        Schema::table('news_events', function (Blueprint $table) {
            // Drop columns that are no longer needed
            if (Schema::hasColumn('news_events', 'monthly_subtype')) {
                $table->dropColumn('monthly_subtype');
            }
            if (Schema::hasColumn('news_events', 'yearly_subtype')) {
                $table->dropColumn('yearly_subtype');
            }
            
            // Rename monthly_week to just handle both monthly and yearly
            if (Schema::hasColumn('news_events', 'monthly_week')) {
                // Keep monthly_week but it will now be used for both monthly and yearly
                // Just update the column type to handle 'last' value
                $table->string('monthly_week')->nullable()->change();
            } else {
                $table->string('monthly_week')->nullable()->after('recurring_type');
            }
            
            // Add yearly_week column
            if (!Schema::hasColumn('news_events', 'yearly_week')) {
                $table->string('yearly_week')->nullable()->after('monthly_week');
            }
        });
    }

    public function down()
    {
        Schema::table('news_events', function (Blueprint $table) {
            // Add back the dropped columns
            $table->string('monthly_subtype')->nullable()->after('recurring_type');
            $table->string('yearly_subtype')->nullable()->after('monthly_week');
            
            // Drop yearly_week
            if (Schema::hasColumn('news_events', 'yearly_week')) {
                $table->dropColumn('yearly_week');
            }
        });
    }
}