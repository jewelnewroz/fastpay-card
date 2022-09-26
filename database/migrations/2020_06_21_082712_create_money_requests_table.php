<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('money_requests')) {
            Schema::create('money_requests', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('sender_id')->index();
                $table->unsignedInteger('receiver_id')->index();
                $table->decimal('amount', 13, 2);
                $table->enum('type', ['cash', 'virtual']);
                $table->string('file_path');
                $table->tinyInteger('status')->default(0);
                $table->string('remarks')->nullable();
                $table->timestamp('task_completed_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('money_requests');
    }
}
