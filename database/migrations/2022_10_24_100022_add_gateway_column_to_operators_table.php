<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGatewayColumnToOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operators', function (Blueprint $table) {
            if(!Schema::hasColumn('operators', 'gateway')) {
                $table->string('gateway')->default('own_card');
                $table->string('category');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operators', function (Blueprint $table) {
            if(Schema::hasColumn('operators', 'gateway')) {
                $table->dropColumn(['gateway', 'category']);
            }
        });
    }
}
