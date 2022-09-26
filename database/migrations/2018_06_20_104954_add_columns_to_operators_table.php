<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('operators')) {
            Schema::table('operators', function (Blueprint $table) {
                $table->char('currency', 4)->default('IQD')->after('user_id');
                $table->string('action_url')->nullable()->after('currency');
                $table->text('additional_params')->nullable()->after('action_url');
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
            $table->dropColumn('currency');
            $table->dropColumn('additional_params');
        });
    }
}
