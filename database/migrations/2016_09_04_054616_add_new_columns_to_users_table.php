<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('date_of_birth', 'reference_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->date('date_of_birth')->nullable()->after('name');
                $table->string('fathers_name', 80)->nullable()->after('date_of_birth');
                $table->string('mothers_name', 80)->nullable()->after('fathers_name');
                /**
                 * ISO/IEC 5218 Information technology —
                 * Codes for the representation of human sexes has single-digit numeric codes:
                 * 0 = not known, 1 = male, 2 = female, 9 = not applicable.
                 */
                $table->tinyInteger('gender')->default(0)->after('mothers_name')
                    ->comment('0 = not known, 1 = male, 2 = female, 9 = not applicable');
                $table->boolean('marital_status')->default(0)->after('gender')
                    ->comment('0 = Single, 1 = Married');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('date_of_birth');
            $table->dropColumn('fathers_name');
            $table->dropColumn('mothers_name');
            $table->dropColumn('gender');
            $table->dropColumn('marital_status');
        });
    }
}
