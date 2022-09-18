<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMintRouteRequestResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mint_route_request_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->json('request_param')->nullable();
            $table->json('response_param')->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->string('api',255)->nullable();
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
        Schema::dropIfExists('mint_route_request_responses');
    }
}
