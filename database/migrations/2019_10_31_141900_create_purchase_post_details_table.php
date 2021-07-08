<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasePostDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_post_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_post_id')->index();
            $table->unsignedBigInteger('product_id');
            $table->decimal('price', 18, 2);
            $table->json('quantity');
            $table->string('note')->nullable();
            $table->boolean('is_guaranteed')->default(0);
            $table->date('warranty_expiration_date')->nullable();
            $table->text('warranty_terms_and_conditions')->nullable();
            $table->timestamps();

            $table->foreign('purchase_post_id')->references('id')->on('purchase_posts');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_post_details');
    }
}
