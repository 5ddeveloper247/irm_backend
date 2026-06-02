<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('jazz_cash_account_title', 150)->nullable()->after('youtube_link');
            $table->string('jazz_cash_account_number', 50)->nullable()->after('jazz_cash_account_title');
            $table->string('jazz_cash_qr', 255)->nullable()->after('jazz_cash_account_number');
            $table->string('easypaisa_account_title', 150)->nullable()->after('jazz_cash_qr');
            $table->string('easypaisa_account_number', 50)->nullable()->after('easypaisa_account_title');
            $table->string('easypaisa_qr', 255)->nullable()->after('easypaisa_account_number');
            $table->string('bank_account_title', 150)->nullable()->after('easypaisa_qr');
            $table->string('bank_account_number', 50)->nullable()->after('bank_account_title');
            $table->string('bank_name', 150)->nullable()->after('bank_account_number');
            $table->string('bank_qr', 255)->nullable()->after('bank_name');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'jazz_cash_account_title',
                'jazz_cash_account_number',
                'jazz_cash_qr',
                'easypaisa_account_title',
                'easypaisa_account_number',
                'easypaisa_qr',
                'bank_account_title',
                'bank_account_number',
                'bank_name',
                'bank_qr',
            ]);
        });
    }
};
