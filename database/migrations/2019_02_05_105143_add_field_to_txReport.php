<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToTxReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('transaction_reports', 'current_balance')) {
            Schema::table('transaction_reports', function (Blueprint $table) {
                $table->decimal('current_balance', 16, 2)->after('credit');
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
        Schema::table('transaction_reports', function (Blueprint $table) {
            $table->dropColumn('current_balance');
        });
    }
}
