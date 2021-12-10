<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployeeScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_schedule', function (Blueprint $table) {
            $table->foreign(['user_id'], 'fk_schedule_user_id')->references(['id'])->on('users');
            $table->foreign(['create_by'], 'fk_schedule_created_by')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_schedule', function (Blueprint $table) {
            $table->dropForeign('fk_schedule_user_id');
            $table->dropForeign('fk_schedule_created_by');
        });
    }
}
