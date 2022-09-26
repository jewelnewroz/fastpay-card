<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('transaction_reports')) {
            Schema::create('transaction_reports', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('tx_unique_id', 10)->index();
                $table->string('account_code', 32);
                $table->string('mobile_no', 24)->index();
                $table->string('account_name', 64);
                $table->string('account_type', 32)->index();
                $table->string('account_role', 32)->nullable();
                $table->string('transaction_type', 64);
                $table->decimal('transaction_amount', 16, 2);
                $table->decimal('debit', 16, 2);
                $table->decimal('credit', 16, 2);
                $table->string('tx_reference', 64)->nullable();
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
        Schema::dropIfExists('transaction_reports');
    }
}
