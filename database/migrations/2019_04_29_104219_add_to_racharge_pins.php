<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToRachargePins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recharge_pins', function (Blueprint $table) {
            $table->unsignedInteger('transaction_id')->nullable()->after('operator_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recharge_pins', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
}
