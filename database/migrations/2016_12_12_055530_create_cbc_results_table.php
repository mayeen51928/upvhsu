<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbcResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbc_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->nullable();
            $table->foreign('patient_id')->references('patient_id')->on('patient_info')->onDelete('cascade');
            $table->integer('medical_appointment_id')->unsigned()->index()->nullable();
            $table->foreign('medical_appointment_id')->references('id')->on('medical_appointments')->onDelete('cascade');
            $table->integer('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('staff_id')->on('staff_info')->onDelete('cascade');
            $table->integer('lab_staff_id');
            $table->foreign('lab_staff_id')->references('staff_id')->on('staff_info')->onDelete('cascade');
            $table->text('hemoglobin')->nullable();
            $table->text('hemasocrit')->nullable();
            $table->text('wbc')->nullable();
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
        Schema::dropIfExists('cbc_results');
    }
}
