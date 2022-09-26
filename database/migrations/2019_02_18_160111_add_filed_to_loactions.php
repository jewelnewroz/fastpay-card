<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledToLoactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('locations', 'open')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('open', 32)->nullable();
                $table->string('close', 32)->nullable()->after('open');
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
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('open');
            $table->dropColumn('close');
        });
    }
}
