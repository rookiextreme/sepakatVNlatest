<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentFormCheckLvl3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment.assessment_form_check_lvl3', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vehicle_id')->nullable();
            // $table->foreign('vehicle_id')->references('id')->on('assessment.assessment_new_vehicle');

            $table->unsignedBigInteger('checklistlvl3_id')->nullable();
            $table->foreign('checklistlvl3_id')->references('id')->on('ref_component_checklist_lvl3');

            $table->unsignedBigInteger('formchecklistlvl2_id')->nullable();
            $table->foreign('formchecklistlvl2_id')->references('id')->on('assessment.assessment_form_check_lvl2');

            $table->boolean('is_pass')->default(false);

            $table->string('note')->nullable();

            $table->unsignedBigInteger('doc_id')->nullable();
            $table->foreign('doc_id')->references('id')->on('assessment.assessment_formcheck_doc');

            $table->unsignedBigInteger('noted_by')->nullable();
            $table->foreign('noted_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('assessment.assessment_form_check_lvl2');
    }
}
