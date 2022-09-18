<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraColumnsToCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->string('sender_tax', 32)->default(0)->after('receiver_commission');
            $table->string('receiver_tax', 32)->default(0)->after('sender_tax');
            $table->string('sender_service_charge', 32)->default(0)->after('receiver_tax');
            $table->string('receiver_service_charge', 32)->default(0)->after('sender_service_charge');
            $table->string('fastpay_share', 32)->default(0)->after('receiver_service_charge');
            $table->string('distributor_share', 32)->default(0)->after('fastpay_share');
            $table->string('ssl_share', 32)->default(0)->after('distributor_share');
            $table->decimal('from', 16, 2)->after('ssl_share');
            $table->decimal('to', 16, 2)->after('from');
            $table->decimal('min_amount', 16, 2)->after('to');
            $table->decimal('max_amount', 16, 2)->after('min_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commissions', function (Blueprint $table) {
            //
        });
    }
}
