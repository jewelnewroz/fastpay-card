<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlipHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('slip_histories')) {
            Schema::create('slip_histories', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('tx_id');
                $table->string('tx_type', 16);
                $table->integer('tx_type_id');
                $table->string('sender_id', 24);
                $table->string('sender_name', 64);
                $table->string('sender_mobile_no', 16);
                $table->string('receiver_id', 24);
                $table->string('receiver_name', 64);
                $table->string('receiver_mobile_no', 16);
                $table->double('amount', 14, 2);
                $table->dateTime('tx_date_time');
                $table->string('operator', 64)->nullable();
                $table->json('tx_response')->nullable();
                $table->json('instruction_messages')->nullable();
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
        Schema::dropIfExists('slip_histories');
    }
}
