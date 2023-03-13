<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentFormCheckLvl1Selection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment.assessment_form_check_lvl1_selection', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('assessment_form_check_lvl1_id')->nullable();
            $table->foreign('assessment_form_check_lvl1_id')->references('id')->on('assessment.assessment_form_check_lvl1');

            $table->unsignedBigInteger('table_selection_id')->nullable();
            $table->foreign('table_selection_id')->references('id')->on('ref_table_selection');

            $table->unsignedBigInteger('selection_id')->nullable();
            $table->foreign('selection_id')->references('id')->on('ref_selection');

            $table->smallInteger('selected_id')->nullable();
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
        Schema::dropIfExists('assessment.assessment_form_check_lvl1_selection');
    }
}
