<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorRequestParamsTable extends Migration
{
    public function up()
    {
        Schema::create('operator_request_params', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('operator_id');
            $table->string('name');
            $table->string('type')->default('text');
            $table->string('label');
            $table->string('placeholder')->nullable();
            $table->tinyInteger('is_required')->default(true);
            $table->timestamps();
            $table->softDeletesTz();
        });
    }

    public function down()
    {
        Schema::dropIfExists('operator_request_params');
    }
}
