<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMintRouteBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mint_route_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('name',64);
            $table->integer('brand_id');
            $table->char('currency', 4)->default('IQD');
            $table->string('logo', 120);
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->json('eligibility')->nullable();
            $table->boolean('status')->default(true);
            $table->string('instructions',255)->nullable();
            $table->string('instructions_ar',255)->nullable();
            $table->string('instructions_ku',255)->nullable();
            $table->string('response_params',120)->nullable();
            $table->tinyInteger('position');
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
        Schema::dropIfExists('mint_route_brands');
    }
}
