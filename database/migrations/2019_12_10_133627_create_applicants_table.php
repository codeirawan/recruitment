<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->char('phone_number', 15)->nullable();
            $table->string('resume');
            $table->unsignedBigInteger('resume_source_id')->index();
            $table->unsignedBigInteger('position_id')->index();
            $table->char('city_id', 4)->index();
            $table->dateTime('interview_at')->nullable();
            $table->dateTime('register_at')->nullable();
            $table->enum('status', ['Pending', 'Qualified', 'Not Qualified', 'Canceled', 'Scheduled', 'Passed', 'Not Passed']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('resume_source_id')->references('id')->on('master_resume_sources');
            $table->foreign('position_id')->references('id')->on('master_positions');
            $table->foreign('city_id')->references('id')->on('master_cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
