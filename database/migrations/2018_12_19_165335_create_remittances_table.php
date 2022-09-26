<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemittancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('remittances')) {
            Schema::create('remittances', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id')->unsigned()->index();
                $table->foreign('user_id')->references('id')->on('users');

                $table->integer('remittance_channel_id')->unsigned()->index();
                $table->foreign('remittance_channel_id')->references('id')->on('remittance_channels');

                $table->integer('country_id')->unsigned()->index();
                $table->foreign('country_id')->references('id')->on('countries');

                $table->integer('bank_id')->unsigned()->index();
                $table->foreign('bank_id')->references('id')->on('banks');

                $table->integer('branch_id')->unsigned()->index();
                $table->foreign('branch_id')->references('id')->on('branches');

                $table->integer('transaction_id')->unsigned()->index();
                $table->foreign('transaction_id')->references('id')->on('transactions');

                $table->string('account_name', 80)->index()->nullable();
                $table->string('account_number', 64)->index()->nullable();
                $table->string('mobile_number', 32)->index()->nullable();

                $table->string('currency', 6)->index();
                $table->decimal('amount', 16, 2)->default(0);

                $table->string('code', 64)->index()->nullable();
                $table->tinyInteger('status')->default(0); # 0 = Pending, 1 = Processed, 2 = Cancelled, 3 = Failed
                $table->json('body')->nullable();
                $table->string('remarks')->nullable();

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
        Schema::dropIfExists('remittances');
    }
}
