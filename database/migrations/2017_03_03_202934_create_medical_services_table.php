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
            $table->decimal('student_rate')->nullable();
            $table->decimal('faculty_staff_dependent_rate')->nullable();
            $table->decimal('opd_rate')->nullable();
            $table->decimal('senior_rate')->nullable();
            $table->enum('service_type', ['medical', 'xray', 'cbc', 'drugtest', 'fecalysis', 'urinalysis']);
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
