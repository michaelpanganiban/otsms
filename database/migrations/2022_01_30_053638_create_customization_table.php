<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customization', function (Blueprint $table) {
            $table->bigInteger('custom_id', true);
            $table->string('reference_id', 50);
            $table->string('garment_type', 50);
            $table->text('details');
            $table->unsignedBigInteger('user_id')->index('fk_custom_user_id');
            $table->string('status', 15)->default('Pending');
            $table->date('pickup_date');
            $table->double('downpayment');
            $table->double('fullpayment')->nullable();
            $table->double('price')->nullable();
            $table->text('proof_of_payment');
            $table->text('design');
            $table->text('classification');
            $table->dateTime('created_at')->useCurrent();
            $table->bigInteger('tailor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customization');
    }
}
