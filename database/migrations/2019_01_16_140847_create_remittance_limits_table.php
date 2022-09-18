<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemittanceLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remittance_limits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('remittance_channel_id')->unsigned()->index();
            $table->foreign('remittance_channel_id')->references('id')->on('remittance_channels')->onDelete('cascade');
            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->mediumInteger('max_limit')->default(0);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('remittance_limits');
    }
}
