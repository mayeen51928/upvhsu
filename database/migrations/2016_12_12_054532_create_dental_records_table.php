<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appointment_id')->unsigned()->index();
            $table->foreign('appointment_id')->references('id')->on('dental_appointments')->onDelete('cascade');
            $table->integer('teeth_id')->unsigned()->index();
            $table->foreign('teeth_id')->references('id')->on('teeth_info')->onDelete('cascade');
            $table->integer('condition_id')->unsigned()->index();
            $table->foreign('condition_id')->references('id')->on('dental_conditions')->onDelete('cascade');
            $table->integer('operation_id')->unsigned()->index();
            $table->foreign('operation_id')->references('id')->on('dental_operations')->onDelete('cascade');
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
        Schema::dropIfExists('dental_records');
    }
}
