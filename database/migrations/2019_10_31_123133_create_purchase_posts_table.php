<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('total_price', 18, 2);
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->boolean('pay_later')->default(0);
            $table->string('proof_of_payment')->nullable();
            $table->enum('status', ['Waiting for Approval', 'Voided', 'Approved', 'Postponed', 'Rejected', 'Processed', 'Returned', 'Incomplete', 'Completed']);
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('payment_method_id')->references('id')->on('master_payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_posts');
    }
}
