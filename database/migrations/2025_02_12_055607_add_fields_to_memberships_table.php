<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('memberships', function (Blueprint $table) {
            // membership_type
            $table->string('membership_type')->default('basic')->nullable()->after('message');
            $table->string('father_name')->nullable()->after('message');
            $table->string('gender')->nullable()->after('message');
            $table->text('present_address')->nullable()->after('message');
            $table->text('permanent_address')->nullable()->after('message');
            $table->string('province')->nullable()->after('message');
            $table->string('district')->nullable()->after('message');
            $table->string('tehsil')->nullable()->after('message');
            $table->string('whatsapp_number')->nullable()->after('message');
            $table->string('cnic_number')->nullable()->after('message');
            $table->date('date_of_birth')->nullable()->after('message');
            $table->string('education')->nullable()->after('message');
        });
    }

    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn([
                'membership_type',
                'father_name',
                'gender',
                'present_address',
                'permanent_address',
                'province',
                'district',
                'tehsil',
                'whatsapp_number',
                'cnic_number',
                'date_of_birth',
                'education',
            ]);
        });
    }
};

