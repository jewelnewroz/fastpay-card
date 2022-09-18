<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('transaction_id')->unsigned()->index()->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null');
            $table->integer('transaction_type_id')->unsigned()->index()->nullable();
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('set null');
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('description', 150);
            $table->decimal('debit', 16, 2);
            $table->decimal('credit', 16, 2);
            $table->decimal('current_balance', 16, 2);
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
        Schema::drop('statements');
    }
}
