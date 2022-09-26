<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReportingColumnsToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('transactions', 'sender_fee')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->decimal('sender_fee', 10, 2)->default(0);
                $table->decimal('sender_tax', 10, 2)->default(0);
                $table->decimal('sender_commission', 10, 2)->default(0);
                $table->decimal('sender_service_charge', 10, 2)->default(0);

                $table->decimal('receiver_fee', 10, 2)->default(0);
                $table->decimal('receiver_tax', 10, 2)->default(0);
                $table->decimal('receiver_commission', 10, 2)->default(0);
                $table->decimal('receiver_service_charge', 10, 2)->default(0);

                $table->decimal('fastpay_share', 10, 2)->default(0);
                $table->decimal('ssl_share', 10, 2)->default(0);
                $table->decimal('distributor_share', 10, 2)->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
