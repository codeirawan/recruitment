<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasePostValidateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_post_validate_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_post_validate_id')->index();
            $table->unsignedBigInteger('purchase_post_detail_id')->index();
            $table->unsignedInteger('lack');
            $table->unsignedInteger('defective');
            $table->timestamps();

            $table->foreign('purchase_post_validate_id')->references('id')->on('purchase_post_validates');
            $table->foreign('purchase_post_detail_id')->references('id')->on('purchase_post_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_post_validate_details');
    }
}
