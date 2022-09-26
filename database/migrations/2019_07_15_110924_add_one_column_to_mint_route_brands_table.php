<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOneColumnToMintRouteBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('mint_route_brands', 'operator_id')) {
            Schema::table('mint_route_brands', function (Blueprint $table) {
                $table->integer('operator_id')->after('id');
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
        Schema::table('mint_route_brands', function (Blueprint $table) {
            $table->dropColumn('operator_id');
        });
    }
}
