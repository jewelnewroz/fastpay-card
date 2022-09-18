<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTransationReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_reports', function (Blueprint $table) {
            $table->bigInteger('user_id')->index()->after('tx_unique_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_reports', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('current_balance');
        });
    }
}
