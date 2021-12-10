<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('order_id', true);
            $table->bigInteger('product_id')->index('fk_orders_product_id');
            $table->string('reference_id', 100)->nullable();
            $table->unsignedBigInteger('user_id')->index('fk_orders_user_id');
            $table->date('pickup_date')->nullable();
            $table->double('downpayment_amount')->nullable();
            $table->text('receipt')->nullable();
            $table->date('return_date')->nullable();
            $table->integer('addtional_fee')->nullable();
            $table->string('status', 50)->nullable()->default('Pending');
            $table->unsignedBigInteger('created_by')->index('fk_orders_created_by');
            $table->dateTime('created_at')->useCurrent();
            $table->unsignedBigInteger('modified_by')->nullable()->index('fk_orders_modified_by');
            $table->dateTime('modified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
