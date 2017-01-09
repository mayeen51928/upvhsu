<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuardianInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardian_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guardian_first_name');
            $table->string('guardian_middle_name')->nullable();
            $table->string('guardian_last_name');
            $table->string('guardian_contact_number')->nullable();
            $table->string('guardian_telephone_number')->nullable();
            $table->string('street');
            $table->integer('town_id')->unsigned()->index();
            $table->foreign('town_id')->references('id')->on('towns')->onDelete('cascade');
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
        Schema::dropIfExists('guardian_info');
    }
}
