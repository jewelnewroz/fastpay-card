<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToRechargePlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('recharge_plans', 'eligibility')) {
            Schema::table('recharge_plans', function (Blueprint $table) {
                $table->json('eligibility')->nullable();
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
        Schema::table('recharge_plans', function (Blueprint $table) {
            $table->dropColumn('eligibility');
        });
    }
}
