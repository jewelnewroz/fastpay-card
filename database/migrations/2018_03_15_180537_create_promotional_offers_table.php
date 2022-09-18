<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionalOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotional_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('promotion_id')->unsigned()->index()->nullable();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('set null');
            $table->integer('commission_id')->unsigned()->index()->nullable();
            $table->foreign('commission_id')->references('id')->on('commissions')->onDelete('set null');
            $table->string('title', 32);
            $table->enum('disbursement_to', ['Sender', 'Receiver'])->default('Sender');
            $table->decimal('amount', 8, 2)->default(0);
            $table->enum('percentage_or_fixed', ['f', 'p'])->default('f');
            $table->string('avail_limit', 3)->comment("1 for Once, x for x times, I for Infinite");
            $table->integer('created_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('promotional_offers');
    }
}
