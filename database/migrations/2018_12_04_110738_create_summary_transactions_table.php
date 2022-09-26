<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummaryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('summary_transactions')) {
            Schema::create('summary_transactions', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('transaction_id', 32)->index();
                $table->string('transaction_type', 32)->index();

                $table->string('sender_id', 32)->index();
                $table->string('sender_account_no', 32);
                $table->string('sender_name', 80);
                $table->string('sender_mobile_number', 32)->index();

                $table->string('receiver_id', 32)->index();
                $table->string('receiver_account_no', 32);
                $table->string('receiver_name', 80);
                $table->string('receiver_mobile_number', 32)->index();

                $table->string('order_id', 80)->nullable();

                $table->decimal('amount', 16, 2)->default(0);

                $table->string('status', 32)->index();

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
                $table->timestamps();
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
        Schema::dropIfExists('summary_transactions');
    }
}
