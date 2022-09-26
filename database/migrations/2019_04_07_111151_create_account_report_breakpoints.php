<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountReportBreakpoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('account_report_breakpoints')) {
            Schema::create('account_report_breakpoints', function (Blueprint $table) {
                $table->increments('id');
                $table->string('range', 32);
                $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('account_report_breakpoints');
    }
}
