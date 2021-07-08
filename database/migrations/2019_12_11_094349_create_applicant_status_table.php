<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('applicant_id')->index();
            $table->enum('status', ['Pending', 'Qualified', 'Not Qualified', 'Canceled', 'Scheduled', 'Passed', 'Not Passed']);
            $table->dateTime('at');
            $table->unsignedBigInteger('by');
            $table->string('note')->nullable();

            $table->foreign('applicant_id')->references('id')->on('applicants');
            $table->foreign('by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_status');
    }
}
