<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsumerIdColumnToRechargePinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recharge_pins', function (Blueprint $table) {
            $table->integer('consumer_id')->unsigned()->index()->nullable();
            $table->foreign('consumer_id')->references('id')->on('users')->onDelete('set null');
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
            $table->dropIndex(['consumer_id']);
            $table->dropForeign(['consumer_id']);
            $table->dropColumn('consumer_id');
        });
    }
}
