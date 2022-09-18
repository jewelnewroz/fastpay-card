<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id')->unsigned()->index();
            $table->foreign('merchant_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('store_url')->nullable();
            $table->string('ipn_url')->nullable();
            $table->string('success_url')->nullable();
            $table->string('cancel_url')->nullable();
            $table->string('fail_url')->nullable();
            $table->string('store_password')->nullable();
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
        Schema::dropIfExists('store_configurations');
    }
}
