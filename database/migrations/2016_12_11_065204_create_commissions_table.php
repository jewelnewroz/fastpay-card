<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sender', 32);
            $table->string('receiver', 32);
            $table->integer('transaction_type_id')->unsigned()->index()->nullable();
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('set null');
            $table->string('sender_commission', 32)->default(0);
            $table->string('receiver_commission', 32)->default(0);
            $table->boolean('status')->default(true);
            $table->integer('country_id')->unsigned()->index();
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
        Schema::drop('commissions');
    }
}
