<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->foreign('patient_id')->references('patient_id')->on('patient_info')->onDelete('cascade');
            $table->integer('dental_schedule_id')->unsigned()->index();
            $table->foreign('dental_schedule_id')->references('id')->on('dental_schedules')->onDelete('cascade');
            $table->text('reasons');
            $table->enum('status', ['0', '1']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dental_appointments');
    }
}
