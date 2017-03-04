<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_description');
            $table->string('service_rate');
            $table->enum('service_type', ['lab', 'medical', 'xray']);
            $table->integer('patient_type_id')->unsigned()->index();
            $table->foreign('patient_type_id')->references('id')->on('patient_types')->onDelete('cascade');
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
        Schema::dropIfExists('medical_services');
    }
}
