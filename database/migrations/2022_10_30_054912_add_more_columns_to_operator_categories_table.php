<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToOperatorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operator_categories', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->tinyInteger('position_number')->default(99);
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operator_categories', function (Blueprint $table) {
            $table->dropColumn(['icon', 'position_number', 'status', 'deleted_at']);
        });
    }
}
