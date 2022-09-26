<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnVartualBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('virtual_balances', 'remarks')) {
            Schema::table('virtual_balances', function (Blueprint $table) {
                $table->string('remarks', 255)->nullable();
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
        Schema::table('virtual_balances', function (Blueprint $table) {
            $table->dropColumn('remarks');


        });
    }
}
