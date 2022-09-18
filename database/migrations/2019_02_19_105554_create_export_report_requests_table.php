<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportReportRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_report_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('feature',64)->index();
            $table->json('request_query');
            $table->string('file_path')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_report_requests');
    }
}
