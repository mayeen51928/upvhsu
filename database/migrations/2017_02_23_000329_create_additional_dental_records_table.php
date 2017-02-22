<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalDentalRecordsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('additional_dental_records', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('appointment_id')->unsigned()->index();
      $table->foreign('appointment_id')->references('id')->on('dental_appointments')->onDelete('cascade');
			$table->enum('dental_caries', ['Yes', 'No']);
			$table->enum('gingivitis', ['Yes', 'No']);
			$table->enum('peridontal_pocket', ['Yes', 'No']);
			$table->enum('oral_debris', ['Yes', 'No']);
			$table->enum('calculus', ['Yes', 'No']);
			$table->enum('neoplasm', ['Yes', 'No']);
			$table->enum('dental_facio_anomaly', ['Yes', 'No']);
			$table->integer('teeth_present')->nullable();
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
		Schema::dropIfExists('additional_dental_records');
	}
}
