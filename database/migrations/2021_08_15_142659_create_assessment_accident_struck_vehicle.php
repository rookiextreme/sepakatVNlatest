<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentAccidentStruckVehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment.assessment_accident_struck_vehicle', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('assessment_accident_vehicle_id')->nullable();
            $table->foreign('assessment_accident_vehicle_id')->references('id')->on('assessment.assessment_accident_vehicle');

            $table->string('accwit_regno');
            $table->string('vehicle_desc');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('ref_category');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')->references('id')->on('ref_sub_category');
            $table->unsignedBigInteger('sub_category_type_id')->nullable();
            $table->foreign('sub_category_type_id')->references('id')->on('ref_sub_category_type');

            $table->string('plate_no')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('chasis_no')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('foremen_by')->nullable();
            $table->foreign('foremen_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('assessment_by')->nullable();
            $table->foreign('assessment_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('verify_by')->nullable();
            $table->foreign('verify_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('assessment.assessment_accident_struck_vehicle');
    }
}
