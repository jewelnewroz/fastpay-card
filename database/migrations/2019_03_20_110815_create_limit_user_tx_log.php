<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLimitUserTxLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limit_user_tx_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('transaction_type_id')->nullable();

            $table->integer('daily_total_out_tx')->nullable();
            $table->unsignedBigInteger('daily_total_amount_out_tx')->nullable();
            $table->integer('monthly_total_out_tx')->nullable();
            $table->unsignedBigInteger('monthly_total_amount_out_tx')->nullable();

            $table->integer('daily_total_in_tx')->nullable();
            $table->unsignedBigInteger('daily_total_amount_in_tx')->nullable();
            $table->integer('monthly_total_in_tx')->nullable();
            $table->unsignedBigInteger('monthly_total_amount_in_tx')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('limit_user_tx_log');
    }
}
