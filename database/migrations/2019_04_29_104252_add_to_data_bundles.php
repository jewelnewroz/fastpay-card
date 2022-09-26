<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToDataBundles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('bundles', 'transaction_id')) {
            Schema::table('bundles', function (Blueprint $table) {
                $table->unsignedInteger('transaction_id')->nullable();
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
        Schema::table('data_bundles', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
}
