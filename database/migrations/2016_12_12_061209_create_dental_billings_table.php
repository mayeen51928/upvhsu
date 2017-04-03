<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_billings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dental_service_id')->unsigned()->index();
            // $table->foreign('dental_service_id')->references('id')->on('dental_services')->onDelete('cascade');
            $table->integer('appointment_id')->unsigned()->index();
            $table->foreign('appointment_id')->references('id')->on('dental_appointments')->onDelete('cascade');
            $table->enum('status', ['paid', 'unpaid']);
            $table->decimal('amount');
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
        Schema::dropIfExists('dental_billings');
    }
}
