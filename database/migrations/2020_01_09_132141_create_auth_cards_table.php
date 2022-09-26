<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('auth_cards')) {
            Schema::create('auth_cards', function (Blueprint $table) {
                $table->increments('id');
                $table->string('mobile_no', 32)->unique();
                $table->string('email', 120)->unique();
                $table->enum('account_type', ['Personal', 'Merchant', 'Agent', 'Admin', 'Sales', 'Other']);
                $table->string('qr_code')->unique();
                $table->string('uploaded_by');
                $table->string('owner_id')->nullable();
                $table->tinyInteger('is_printed')->default(0);
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
        Schema::dropIfExists('auth_cards');
    }
}
