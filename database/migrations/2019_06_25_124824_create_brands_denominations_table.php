<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsDenominationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('brands_denominations')) {
            Schema::create('brands_denominations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('mint_route_brand_id');
                $table->integer('denomination_id');
                $table->decimal('denomination', 10, 2);
                $table->char('denomination_currency', 4)->default('USD');
                $table->string('validity', 120);
                $table->decimal('contract_price', 10, 2);
                $table->boolean('is_fixed_denomination')->default(true);
                $table->string('logo', 120);
                $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('brands_denominations');
    }
}
