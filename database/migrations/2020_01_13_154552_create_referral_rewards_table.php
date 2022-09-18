<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->integer('from');
            $table->integer('to');
            $table->double('referrer_reward',10,2)->default(0);
            $table->double('registered_user_reward',10,2)->default(0);
            $table->tinyInteger('status');
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
        Schema::dropIfExists('referral_rewards');
    }
}
