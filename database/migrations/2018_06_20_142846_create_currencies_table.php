<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('currencies')) {
            Schema::create('currencies', function (Blueprint $table) {
                $table->increments('id');
                $table->decimal('from_amount', 16, 2)->index();
                $table->decimal('to_amount', 16, 2)->index();
                $table->char('from_currency', 4)->index();
                $table->char('to_currency', 4)->index();
                $table->decimal('rate', 12, 4);
                $table->decimal('fee', 12, 4);
                $table->enum('fee_type', ['%', 'F'])->default('%');
                $table->integer('created_by')->unsigned()->index()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('currencies');
    }
}
