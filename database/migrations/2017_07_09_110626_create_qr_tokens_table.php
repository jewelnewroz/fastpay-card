<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQrTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 180)->unique()->index();
            $table->string('payload', 500);
            $table->boolean('status')->default(false)->comment("0 for Generation, 1 for Accepted Payment");
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
        Schema::dropIfExists('qr_tokens');
    }
}
