<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->index();
            $table->string('name');
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('unit_id');
            $table->json('stock');
            $table->string('photo');
            $table->boolean('sku_per_unit')->default(1);
            $table->boolean('mac_address')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('master_product_categories');
            $table->foreign('unit_id')->references('id')->on('master_product_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
