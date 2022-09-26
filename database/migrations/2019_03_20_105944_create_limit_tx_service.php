<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLimitTxService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('limit_tx_service')) {
            Schema::create('limit_tx_service', function (Blueprint $table) {
                $table->increments('id');
                $table->string('account_type', 32)->index();
                $table->unsignedInteger('transaction_type_id')->nullable();
                $table->boolean('verified');

                $table->integer('daily_max_out_tx')->nullable();
                $table->unsignedBigInteger('daily_max_amount_out_tx')->nullable();
                $table->integer('monthly_max_out_tx')->nullable();
                $table->unsignedBigInteger('monthly_max_amount_out_tx')->nullable();

                $table->integer('daily_max_in_tx')->nullable();
                $table->unsignedBigInteger('daily_max_amount_in_tx')->nullable();
                $table->integer('monthly_max_in_tx')->nullable();
                $table->unsignedBigInteger('monthly_max_amount_in_tx')->nullable();
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('limit_tx_service');
    }
}
