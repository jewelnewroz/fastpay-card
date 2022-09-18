<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankRemittanceChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_remittance_channel', function (Blueprint $table) {
            $table->integer('bank_id')->unsigned()->index();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->integer('remittance_channel_id')->unsigned()->index();
            $table->foreign('remittance_channel_id')->references('id')->on('remittance_channels');
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_remittance_channel', function (Blueprint $table) {
            //
        });
    }
}
