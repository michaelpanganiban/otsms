<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sales', function (Blueprint $table) {
            $table->bigInteger('product_id', true);
            $table->string('product_code', 50);
            $table->string('product_name', 100);
            $table->text('description')->nullable();
            $table->string('amount', 50);
            $table->string('quantity', 50);
            $table->text('image');
            $table->string('status', 10)->default('Active');
            $table->string('type', 10);
            $table->unsignedBigInteger('create_by')->index('fk_user_created_by');
            $table->dateTime('created_at')->useCurrent();
            $table->unsignedBigInteger('modified_by')->nullable()->index('fk_user_modified_by');
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
        Schema::dropIfExists('product_sales');
    }
}
