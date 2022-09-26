<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopifyTransactionInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('shopify_transaction_informations')) {
            Schema::create('shopify_transaction_informations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('order_id', 64)->index();
                $table->text('payload');
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
        Schema::dropIfExists('shopify_transaction_informations');
    }
}
