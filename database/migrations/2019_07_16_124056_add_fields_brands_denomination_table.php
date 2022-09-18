<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsBrandsDenominationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands_denominations', function (Blueprint $table) {
            $table->string('title',255)->nullable()->after('id');
            $table->string('store',255)->nullable()->after('denomination_currency');
            $table->char('contract_price_currency', 4)->default('USD')->after('contract_price');
            $table->json('eligibility')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands_denominations', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('store');
            $table->dropColumn('contract_price_currency');
            $table->dropColumn('eligibility');

        });
    }
}
