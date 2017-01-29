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
            $table->string('staff_first_name')->nullable();
            $table->string('staff_middle_name')->nullable();
            $table->string('staff_last_name')->nullable();
            $table->string('position')->nullable();
            $table->enum('sex', ['M', 'F'])->nullable();
            $table->date('birthday')->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Separated', 'Divorced', 'Widowed'])->nullable();
            $table->integer('religion_id')->unsigned()->index()->nullable();
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('cascade');
            $table->integer('nationality_id')->unsigned()->index()->nullable();
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');
            $table->string('street')->nullable();
            $table->integer('town_id')->unsigned()->index()->nullable();
            $table->foreign('town_id')->references('id')->on('towns')->onDelete('cascade');
            $table->string('personal_contact_number')->nullable();
            $table->string('picture')->nullable();
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
