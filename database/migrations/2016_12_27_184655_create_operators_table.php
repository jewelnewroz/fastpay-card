<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('operators')) {
            Schema::create('operators', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 64);
                $table->string('logo', 120);
                $table->boolean('has_data_bundle')->default(false);
                $table->boolean('has_recharge_card')->default(false);
                $table->boolean('is_online_card')->default(false);
                $table->integer('user_id')->unsigned()->index()->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete("set null");
                $table->boolean('status')->default(true);
                $table->smallInteger('position')->default(0);
                $table->json('eligibility')->nullable();
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
        Schema::dropIfExists('operators');
    }
}
