<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_description');
            $table->decimal('student_rate');
            $table->decimal('faculty_staff_dependent_rate');
            $table->decimal('opd_rate');
            $table->decimal('senior_rate');
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
        Schema::dropIfExists('dental_services');
    }
}
