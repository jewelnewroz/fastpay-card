<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayendAnomalies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('dayend_anomalies')) {
            Schema::create('dayend_anomalies', function (Blueprint $table) {
                $table->increments('id');
                $table->string('account_id', 32)->index();
                $table->string('user_id', 32)->index();
                $table->string('account_name', 64);
                $table->string('account_type', 32)->index();
                $table->string('mobile_no', 16)->index();
                $table->double('total_in', 16, 2);
                $table->double('total_out', 16, 2);
                $table->double('computed_balance', 16, 2);
                $table->double('balance', 16, 2);
                $table->double('difference', 16, 2);
                $table->date('report_date');
                $table->timestamps();
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
        Schema::dropIfExists('dayend_anomalies');
    }
}
