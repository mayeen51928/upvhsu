<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id');
            $table->foreign('staff_id')->references('staff_id')->on('staff_info')->onDelete('cascade');
            $table->date('schedule_day');
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
        Schema::dropIfExists('medical_schedules');
    }
}
