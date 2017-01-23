<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_info', function (Blueprint $table) {
            // $table->increments('id');
            $table->integer('patient_id');
            $table->primary('patient_id');
            $table->integer('patient_type_id')->unsigned()->index();
            $table->foreign('patient_type_id')->references('id')->on('patient_types')->onDelete('cascade');
            $table->string('patient_first_name');
            $table->string('patient_middle_name')->nullable();
            $table->string('patient_last_name');
            $table->integer('year_level');
            $table->integer('degree_program_id')->unsigned()->index()->nullable();
            $table->foreign('degree_program_id')->references('id')->on('degree_programs')->onDelete('cascade');
            $table->enum('graduated', ['0', '1']);
            $table->enum('sex', ['M', 'F']);
            $table->date('birthday');
            $table->enum('civil_status', ['Single', 'Married', 'Separated', 'Divorced', 'Widowed']);
            $table->integer('religion_id')->unsigned()->index()->nullable();
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('cascade');
            $table->integer('nationality_id')->unsigned()->index()->nullable();
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');
            $table->string('street')->nullable();
            $table->integer('town_id')->unsigned()->index()->nullable();
            $table->foreign('town_id')->references('id')->on('towns')->onDelete('cascade');
            $table->string('residence_telephone_number')->nullable();
            $table->string('personal_contact_number')->nullable();
            $table->string('residence_contact_number')->nullable();
            $table->date('first_visit')->nullable();
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
        Schema::dropIfExists('patient_info');
    }
}
