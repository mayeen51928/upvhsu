<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrinalysisResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urinalysis_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medical_appointment_id')->unsigned()->index()->nullable();
            $table->foreign('medical_appointment_id')->references('id')->on('medical_appointments')->onDelete('cascade');
            $table->integer('lab_staff_id')->nullable();
            $table->foreign('lab_staff_id')->references('staff_id')->on('staff_info')->onDelete('cascade');
            $table->text('pus_cells')->nullable();
            $table->text('rbc')->nullable();
            $table->enum('albumin', ['negative', 'positive'])->nullable();
            $table->enum('sugar', ['negative', 'positive'])->nullable();
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
        Schema::dropIfExists('urinalysis_results');
    }
}
