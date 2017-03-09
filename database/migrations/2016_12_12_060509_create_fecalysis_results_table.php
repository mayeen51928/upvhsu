<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFecalysisResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fecalysis_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medical_appointment_id')->unsigned()->index()->nullable();
            $table->foreign('medical_appointment_id')->references('id')->on('medical_appointments')->onDelete('cascade');
            $table->integer('lab_staff_id')->nullable();
            $table->foreign('lab_staff_id')->references('staff_id')->on('staff_info')->onDelete('cascade');
            $table->text('macroscopic')->nullable();
            $table->text('microscopic')->nullable();
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
        Schema::dropIfExists('fecalysis_results');
    }
}
