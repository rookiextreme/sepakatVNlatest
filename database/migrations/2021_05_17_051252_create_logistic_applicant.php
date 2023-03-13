<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticApplicant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic.logistic_applicant', function (Blueprint $table) {
            $table->id();

            $table->string('name',100)->nullable();
            $table->string('tel_no',20)->nullable();
            $table->string('email',50)->nullable();

            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('ref_owner');

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
        Schema::dropIfExists('logistic.logistic_applicant');
    }
}
