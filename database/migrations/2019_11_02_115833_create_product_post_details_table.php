<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPostDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_post_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_post_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('sku');
            $table->macAddress('mac_address')->nullable();
            $table->integer('quantity');
            $table->unsignedInteger('last_stock');
            $table->dateTime('voided_at')->nullable();
            $table->unsignedBigInteger('voided_by')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('product_post_id')->references('id')->on('product_posts');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('voided_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_post_details');
    }
}
