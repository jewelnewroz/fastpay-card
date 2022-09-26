<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('account_no', 32)->unique()->nullable();
                $table->string('mobile_no', 32)->unique();
                $table->string('name', 80)->nullable();
                $table->string('password')->nullable();
                $table->string('pin')->nullable();
                $table->string('fcm_key')->nullable();
                $table->string('device_id', 120)->nullable();
                $table->decimal('balance', 16, 2)->default(0);
                $table->string('otp', 20)->nullable();
                $table->string('photo', 160)->nullable();
                $table->string('email', 120)->unique()->nullable();
                $table->boolean('email_verified')->default(false);
                $table->string('address_line1')->nullable();
                $table->string('address_line2')->nullable();
                $table->string('city', 80)->nullable();
                $table->string('state', 80)->nullable(); // consider it as area here
                $table->string('zip', 32)->nullable();
                $table->integer('country_id')->unsigned()->index()->nullable();
                $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
                $table->enum('type', ['Personal', 'Merchant', 'Agent', 'Admin', 'Sales', 'Other'])->default('Personal');
                $table->integer('daily_outbound_tx')->default(0);
                $table->decimal('daily_outbound_tx_amount', 16, 2)->default(0);
                $table->integer('monthly_outbound_tx')->default(0);
                $table->decimal('monthly_outbound_tx_amount', 16, 2)->default(0);
                $table->boolean('status')->default(false);
                $table->string('remarks', 120)->nullable();
                $table->string('api_token')->nullable();
                $table->string('auth_token', 180)->unique()->nullable();
                $table->rememberToken();
                $table->timestamps();
            });

            DB::update("ALTER TABLE users AUTO_INCREMENT = 1000000000;");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
