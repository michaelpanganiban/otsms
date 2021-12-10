<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_schedule', function (Blueprint $table) {
            $table->bigInteger('schedule_id', true);
            $table->unsignedBigInteger('user_id')->index('fk_schedule_user_id');
            $table->string('day', 15);
            $table->time('time_from')->nullable();
            $table->time('time_to')->nullable();
            $table->boolean('off_duty')->nullable();
            $table->unsignedBigInteger('create_by')->index('fk_schedule_created_by');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_schedule');
    }
}
