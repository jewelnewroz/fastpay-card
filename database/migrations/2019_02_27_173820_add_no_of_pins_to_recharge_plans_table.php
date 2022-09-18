<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoOfPinsToRechargePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recharge_plans', function (Blueprint $table) {
            $table->smallInteger('no_of_pins')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recharge_plans', function (Blueprint $table) {
            $table->dropColumn('no_of_pins');
        });
    }
}
