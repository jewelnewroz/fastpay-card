<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryRemittanceChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('country_remittance_channel')) {
            Schema::create('country_remittance_channel', function (Blueprint $table) {
                $table->integer('country_id')->unsigned()->index();
                $table->foreign('country_id')->references('id')->on('countries');
                $table->integer('remittance_channel_id')->unsigned()->index();
                $table->foreign('remittance_channel_id')->references('id')->on('remittance_channels');
                $table->boolean('status')->default(true);
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
        //
    }
}
