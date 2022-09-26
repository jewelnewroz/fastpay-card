<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('bundles')) {
            Schema::create('bundles', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('operator_id')->unsigned()->index()->nullable();
                $table->foreign('operator_id')->references('id')->on('operators')->onDelete('set null');
                $table->string('logo', 120);
                $table->string('bundle_size', 32);
                $table->decimal('price', 10, 2);
                $table->string('top_up_profile', 64);
                $table->boolean('status')->default(true);
                $table->json('eligibility')->nullable();
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
        Schema::dropIfExists('bundles');
    }
}
