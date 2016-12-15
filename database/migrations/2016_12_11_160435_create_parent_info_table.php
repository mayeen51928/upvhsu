<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parent_first_name');
            $table->string('parent_middle_name')->nullable();
            $table->string('parent_last_name');
            $table->string('parent_contact_number')->nullable();
            $table->string('street');
            $table->integer('town_id')->unsigned()->index();
            $table->foreign('town_id')->references('id')->on('towns')->onDelete('cascade');
            $table->integer('province_id')->unsigned()->index();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->integer('region_id')->unsigned()->index();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->enum('sex', ['M', 'F']);
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
        Schema::dropIfExists('parent_info');
    }
}
