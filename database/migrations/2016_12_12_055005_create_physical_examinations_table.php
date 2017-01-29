<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhysicalExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_examinations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medical_appointment_id')->unsigned()->index()->nullable();
            $table->foreign('medical_appointment_id')->references('id')->on('medical_appointments')->onDelete('cascade');
            $table->text('height')->nullable();
            $table->text('weight')->nullable();
            $table->text('blood_pressure')->nullable();
            $table->text('pulse_rate')->nullable();
            $table->text('right_eye')->nullable();
            $table->text('left_eye')->nullable();
            $table->text('head')->nullable();
            $table->text('eent')->nullable();
            $table->text('neck')->nullable();
            $table->text('chest')->nullable();
            $table->text('heart')->nullable();
            $table->text('lungs')->nullable();
            $table->text('abdomen')->nullable();
            $table->text('back')->nullable();
            $table->text('skin')->nullable();
            $table->text('extremities')->nullable();
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
        Schema::dropIfExists('physical_examinations');
    }
}
