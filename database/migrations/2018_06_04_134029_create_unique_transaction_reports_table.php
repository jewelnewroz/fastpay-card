<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniqueTransactionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('unique_transaction_reports', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('month');
          $table->integer('year');
          $table->integer('count')->default(0);
          $table->text('file')->nullable();
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
        Schema::dropIfExists('unique_transaction_reports');
    }
}
