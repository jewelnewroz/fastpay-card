<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargePinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharge_pins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('operator_id')->unsigned()->index();
            $table->foreign('operator_id')->references('id')->on('operators')->onDelete('cascade');
            $table->decimal('denomination', 10, 2);
            $table->string('serial_no', 64);
            $table->string('pin', 64);
            $table->date('expiry_date')->nullable();
            $table->boolean('status')->default(false)->comment('0 for unused, 1 for used');
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
        Schema::dropIfExists('recharge_pins');
    }
}
