<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSlipHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slip_histories', function (Blueprint $table) {
            $table->unsignedInteger('operator_id')->after('operator')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slip_histories', function (Blueprint $table) {
            $table->dropColumn('operator_id');
        });
    }
}
