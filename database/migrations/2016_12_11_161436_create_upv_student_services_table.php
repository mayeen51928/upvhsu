<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpvStudentServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upv_student_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_name');
            $table->decimal('service_rate');
            $table->enum('service_type', ['lab', 'medical', 'xray']);
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
        Schema::dropIfExists('upv_student_services');
    }
}
