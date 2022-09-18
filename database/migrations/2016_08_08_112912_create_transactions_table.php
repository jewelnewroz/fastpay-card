<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id')->unsigned()->index()->nullable();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete("set null");
            $table->integer('receiver_id')->unsigned()->index()->nullable();
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete("set null");
            $table->string('order_id', 80)->nullable();
            $table->integer('type')->unsigned()->index()->nullable();
            $table->foreign('type')->references('id')->on('transaction_types')->onDelete("set null");
            $table->decimal('amount', 16, 2);
            $table->integer('status')->unsigned()->index()->nullable();
            $table->foreign('status')->references('id')->on('transaction_statuses')->onDelete("set null");
            $table->string('otp', 12)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
    }
}
