<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToAccountReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('account_balance_reports', 'user_id')) {
            Schema::table('account_balance_reports', function (Blueprint $table) {
                $table->bigInteger('user_id')->nullable()->after('id');
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
        Schema::table('account_balance_reports', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
