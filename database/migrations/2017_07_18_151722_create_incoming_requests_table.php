<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incoming_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mobile_no', 32)->index();
            $table->string('payload')->nullable();
            $table->string('feature', 32)->index();
            $table->string('ip_address', 64)->index();
            $table->boolean('status')->default(true)->comment("1 = Success, 0 = Fail");
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
        Schema::dropIfExists('incoming_requests');
    }
}
