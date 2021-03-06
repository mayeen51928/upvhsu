<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_billings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medical_service_id')->unsigned()->index();
            // $table->foreign('medical_service_id')->references('id')->on('medical_services')->onDelete('cascade');
            $table->integer('medical_appointment_id')->unsigned()->index()->nullable();
            $table->foreign('medical_appointment_id')->references('id')->on('medical_appointments')->onDelete('cascade');
            $table->enum('status', ['paid', 'unpaid']);
            $table->decimal('amount');
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
        Schema::dropIfExists('medical_billings');
    }
}
