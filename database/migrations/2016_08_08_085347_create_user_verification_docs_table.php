<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUserVerificationDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_verification_docs')) {
            Schema::create('user_verification_docs', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->index()->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                $table->integer('verification_type_id')->unsigned()->index()->nullable();
                $table->foreign('verification_type_id')->references('id')->on('user_verification_types')->onDelete('set null');
                $table->string('verification_doc_id', 120)->comment('NID, Passport, etc. ID');
                $table->string('verification_doc_file', 120)->nullable();
                $table->boolean('status')->default(true)->comment('1 for Verified, 0 for Un-Verified');
                $table->integer('created_by')->unsigned()->index()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                $table->integer('updated_by')->unsigned()->index()->nullable();
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::drop('user_verification_docs');
    }
}
