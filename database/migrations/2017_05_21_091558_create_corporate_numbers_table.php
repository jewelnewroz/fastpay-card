<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporateNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('corporate_numbers')) {
            Schema::create('corporate_numbers', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('corporate_id')->unsigned()->index()->nullable();
                $table->foreign('corporate_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('mobile_no', 32)->index();
                $table->boolean('status')->default(true);
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
        Schema::dropIfExists('corporate_numbers');
    }
}
