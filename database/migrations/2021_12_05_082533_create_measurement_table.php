<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurement', function (Blueprint $table) {
            $table->bigInteger('measurement_id', true);
            $table->unsignedBigInteger('user_id');
            $table->double('shoulder_length')->nullable();
            $table->double('sleeve_length')->nullable();
            $table->double('bust_chest')->nullable();
            $table->double('waist')->nullable();
            $table->double('skirt_length')->nullable();
            $table->double('slack_length')->nullable();
            $table->double('slack_front_rise')->nullable();
            $table->double('slack_fit_seat')->nullable();
            $table->double('slack_fit_thigh')->nullable();
            $table->bigInteger('created_by');
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
        Schema::dropIfExists('measurement');
    }
}
