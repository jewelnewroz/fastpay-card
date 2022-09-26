<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('recharge_plans')) {
            Schema::create('recharge_plans', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('operator_id')->unsigned()->index();
                $table->foreign('operator_id')->references('id')->on('operators')->onDelete('cascade');
                $table->string('logo', 120);
                $table->decimal('amount', 10, 2);
                $table->string('validity', 120);
                $table->boolean('status')->default(true);
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
        Schema::dropIfExists('recharge_plans');
    }
}
