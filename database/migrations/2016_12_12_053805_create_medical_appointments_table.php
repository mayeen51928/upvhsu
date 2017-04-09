<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('priority_number');
            $table->integer('patient_id');
            $table->foreign('patient_id')->references('patient_id')->on('patient_info')->onDelete('cascade');
            $table->integer('medical_schedule_id')->unsigned()->index();
            $table->foreign('medical_schedule_id')->references('id')->on('medical_schedules')->onDelete('cascade');
            $table->text('reasons');
            $table->enum('has_lab_request', ['0', '1', '2']); // 0 -> none 1 -> has lab requests -> finished lab requests
            $table->enum('status', ['0', '1', '2']);
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
        Schema::dropIfExists('medical_appointments');
    }
}
