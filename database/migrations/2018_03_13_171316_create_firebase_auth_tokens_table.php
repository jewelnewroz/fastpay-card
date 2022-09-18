<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirebaseAuthTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firebase_auth_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identifier', 120)->index();
            $table->string('user_uid', 120)->index();
            $table->boolean('is_user')->default(false);
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
        Schema::dropIfExists('firebase_auth_tokens');
    }
}
