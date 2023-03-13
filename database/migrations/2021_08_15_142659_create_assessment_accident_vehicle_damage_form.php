<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentAccidentVehicleDamageForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment.assessment_accident_vehicle_damage_form', function (Blueprint $table) {
            $table->id();

            $table->string('damage');
            $table->string('damage_note')->nullable();
            $table->boolean('is_repair')->default(false);
            $table->boolean('is_replace')->default(false);
            $table->float('price_list')->nullable();
            $table->float('wages_cost')->nullable();
            $table->float('spare_part_price')->nullable();

            $table->unsignedBigInteger('doc_id')->nullable();
            $table->foreign('doc_id')->references('id')->on('assessment.assessment_formcheck_doc');

            $table->unsignedBigInteger('assessment_accident_vehicle_id')->nullable();
            $table->foreign('assessment_accident_vehicle_id')->references('id')->on('assessment.assessment_accident_vehicle');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('verify_by')->nullable();
            $table->foreign('verify_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('approve_by')->nullable();
            $table->foreign('approve_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('assessment.assessment_accident_vehicle_damage_form');
    }
}
