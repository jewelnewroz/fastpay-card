<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchRemittanceChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_remittance_channel', function (Blueprint $table) {
            $table->integer('branch_id')->unsigned()->index();
            $table->foreign('branch_id')->references('id')->on('branches');
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
        Schema::table('branch_remittance_channel', function (Blueprint $table) {
            //
        });
    }
}
