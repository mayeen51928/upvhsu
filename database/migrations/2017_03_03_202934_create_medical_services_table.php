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
            $table->integer('service_rate')->nullable();
            $table->enum('service_type', ['medical', 'xray', 'cbc', 'drugtest', 'fecalysis', 'urinalysis']);
            $table->integer('patient_type_id')->nullable();
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
