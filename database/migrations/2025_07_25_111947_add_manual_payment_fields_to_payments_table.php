<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManualPaymentFieldsToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('module_code'); // jazz_cash, easypaisa, bank_transfer
            $table->string('receipt_path')->nullable()->after('payment_method'); // path to uploaded receipt
            $table->timestamp('verified_at')->nullable()->after('receipt_path'); // when payment was verified
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at'); // admin who verified
            
            // Add foreign key for verified_by
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'payment_method',
                'receipt_path',
                'verified_at',
                'verified_by'
            ]);
        });
    }
}

?>