<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('operators', 'title')) {
            Schema::table('operators', function (Blueprint $table) {
                $table->string('title', 255)->nullable()->after('name');
                $table->string('store', 255)->nullable()->after('logo');

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
        Schema::table('operators', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('store');

        });
    }
}
