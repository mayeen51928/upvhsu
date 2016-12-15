<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHasGuardianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('has_guardian', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->foreign('patient_id')->references('patient_id')->on('patient_info')->onDelete('cascade');
            $table->integer('guardian_id')->unsigned()->index();
            $table->foreign('guardian_id')->references('id')->on('guardian_info')->onDelete('cascade');
            $table->string('relationship');
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
        Schema::dropIfExists('has_guardian');
    }
}
