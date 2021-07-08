<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasePostStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_post_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_post_id')->index();
            $table->enum('status', ['Submitted', 'Voided', 'Approved', 'Postponed', 'Rejected', 'Processed', 'Returned', 'Incomplete', 'Completed']);
            $table->dateTime('at');
            $table->unsignedBigInteger('by');
            $table->string('note')->nullable();
            $table->unsignedBigInteger('purchase_post_validate_id')->nullable();

            $table->foreign('purchase_post_id')->references('id')->on('purchase_posts');
            $table->foreign('by')->references('id')->on('users');
            $table->foreign('purchase_post_validate_id')->references('id')->on('purchase_post_validates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_post_status');
    }
}
