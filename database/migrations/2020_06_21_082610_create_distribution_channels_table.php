<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributionChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('distribution_channels')) {
            Schema::create('distribution_channels', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('parent_id')->index();
                $table->unsignedInteger('child_id')->index();
                $table->string('type', 80)->index();
                $table->boolean('status')->default(1);
                $table->unsignedInteger('added_by')->index();
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
        Schema::dropIfExists('distribution_channels');
    }
}
