<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id');
            $table->foreign('staff_id')->references('staff_id')->on('staff_info')->onDelete('cascade');
            $table->dateTime('schedule_start');
            $table->dateTime('schedule_end');
            $table->enum('booked', ['0', '1'])
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
        Schema::dropIfExists('dental_schedules');
    }
}
