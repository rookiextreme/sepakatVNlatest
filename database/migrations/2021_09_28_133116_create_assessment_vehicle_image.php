<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentVehicleImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment.assessment_vehicle_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->string('doc_type')->nullable();
            $table->string('category')->nullable();
            $table->string('doc_format')->nullable();
            $table->string('doc_path')->nullable();
            $table->string('doc_name')->nullable();
            $table->string('doc_path_thumbnail')->nullable();
            $table->boolean('doc_status')->default(false);
            $table->tinyInteger('is_primary')->default(0);

            $table->unsignedBigInteger('assessment_type_id')->nullable();
            $table->foreign('assessment_type_id')->references('id')->on('assessment.assessment_type');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            // $table->foreign('')

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('assessment.assessment_vehicle_image');
    }
}
