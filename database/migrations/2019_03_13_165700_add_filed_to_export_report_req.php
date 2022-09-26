<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledToExportReportReq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('export_report_requests', 'remark')) {
            Schema::table('export_report_requests', function (Blueprint $table) {
                $table->string('remark', 255)->nullable()->after('user_id');
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
        Schema::table('export_report_requests', function (Blueprint $table) {
            $table->dropColumn('remark');
        });
    }
}
