<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountBalanceReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_balance_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_id',32);
            $table->string('mobile_no',16)->index();
            $table->string('account_name',64);
            $table->string('account_type',32)->index();
            $table->string('account_role',32)->nullable();
            $table->decimal('total_in',16,2);
            $table->decimal('total_out',16,2);
            $table->decimal('balance',16,2);
            $table->date('report_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_balance_reports');
    }
}
