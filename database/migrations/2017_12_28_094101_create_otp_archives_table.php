<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtpArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('otp_archives')) {
            Schema::create('otp_archives', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('mobile_no', 20)->index();
                $table->mediumInteger('otp');
                $table->string('purpose', 32)->index();
                $table->string('client')->nullable();
                $table->ipAddress('ip_address');
                $table->tinyInteger('status')->comment('0 = Generated, 1 = Used, 2 = Expired');
                $table->timestamps();
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
        Schema::dropIfExists('otp_archives');
    }
}
