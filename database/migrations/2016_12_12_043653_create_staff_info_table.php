<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_info', function (Blueprint $table) {
            $table->integer('staff_id');
            $table->primary('staff_id');
            $table->integer('staff_type_id')->unsigned()->index();
            $table->foreign('staff_type_id')->references('id')->on('staff_types')->onDelete('cascade');
            $table->string('staff_first_name');
            $table->string('staff_middle_name')->nullable();
            $table->string('staff_last_name');
            $table->string('position');
            $table->enum('sex', ['M', 'F']);
            $table->date('birthday');
            $table->enum('civil_status', ['Single', 'Married', 'Separated', 'Divorced', 'Widowed']);
            $table->integer('religion_id')->unsigned()->index();
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('cascade');
            $table->integer('nationality_id')->unsigned()->index();
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');
            $table->string('street');
            $table->integer('town_id')->unsigned()->index();
            $table->foreign('town_id')->references('id')->on('towns')->onDelete('cascade');
            $table->integer('province_id')->unsigned()->index();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->integer('region_id')->unsigned()->index();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->string('personal_contact_number');
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
        Schema::dropIfExists('staff_info');
    }
}
