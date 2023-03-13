<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentFormCheckLvl1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment.assessment_form_check_lvl1', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('assessment_type_id')->nullable();
            $table->foreign('assessment_type_id')->references('id')->on('assessment.assessment_type');

            $table->unsignedBigInteger('vehicle_id')->nullable();
            // $table->foreign('vehicle_id')->references('id')->on('assessment.assessment_new_vehicle');

            $table->unsignedBigInteger('checklistlvl1_id')->nullable();
            $table->foreign('checklistlvl1_id')->references('id')->on('ref_component_checklist_lvl1');

            $table->unsignedBigInteger('disposal_percentage_id')->nullable();
            $table->foreign('disposal_percentage_id')->references('id')->on('assessment.assessment_disposal_percentage');

            $table->boolean('is_pass')->default(false);

            $table->string('note')->nullable();
            $table->unsignedBigInteger('noted_by')->nullable();
            $table->foreign('noted_by')->references('id')->on('users.users');

            $table->boolean('is_repair')->nullable();
            $table->boolean('is_repairs')->nullable();
            $table->boolean('is_replacement')->nullable();

            $table->string('receipt_no')->nullable();
            $table->unsignedBigInteger('receipt_doc')->nullable();
            $table->foreign('receipt_doc')->references('id')->on('assessment.assessment_formcheck_doc');
            $table->unsignedBigInteger('vehicle_doc')->nullable();
            $table->foreign('vehicle_doc')->references('id')->on('assessment.assessment_formcheck_doc');
            $table->unsignedBigInteger('vtl_doc')->nullable();
            $table->foreign('vtl_doc')->references('id')->on('assessment.assessment_formcheck_doc');
            $table->string('odo_read')->nullable();
            $table->string('transmission')->nullable();
            $table->float('total_price')->nullable();
            $table->string('evaluation_type')->nullable();

            $table->unsignedBigInteger('fuel_type_id')->nullable();
            $table->foreign('fuel_type_id')->references('id')->on('ref_engine_fuel_type');

            $table->string('wheel_type')->nullable();
            $table->string('bottom_part_cond')->nullable();
            $table->string('inner_part_cond')->nullable();
            $table->string('outer_part_cond')->nullable();

            $table->boolean('engine_system_check')->default(false);
            $table->boolean('trans_system_check')->default(false);
            $table->boolean('susp_system_check')->default(false);
            $table->boolean('brek_system_check')->default(false);
            $table->boolean('wiring_system_check')->default(false);
            $table->boolean('aircond_system_check')->default(false);

            $table->string('engine_system')->nullable();
            $table->string('trans_system')->nullable();
            $table->string('susp_system')->nullable();
            $table->string('brek_system')->nullable();
            $table->string('wiring_system')->nullable();
            $table->string('aircond_system')->nullable();

            $table->string('tyre_year_fl')->nullable();
            $table->string('tyre_year_rl')->nullable();
            $table->string('tyre_year_fr')->nullable();
            $table->string('tyre_year_rr')->nullable();

            $table->integer('total_seat')->nullable();

            $table->integer('tyre_front_left_percentage')->nullable();

            $table->integer('tyre_front_right_percentage')->nullable();

            $table->integer('tyre_back_left_percentage')->nullable();

            $table->integer('tyre_back_right_percentage')->nullable();

            $table->dateTime('assessment_dt')->nullable();
            $table->unsignedBigInteger('assessment_by')->nullable();
            $table->foreign('assessment_by')->references('id')->on('users.users');

            $table->dateTime('verify_dt')->nullable();
            $table->unsignedBigInteger('verify_by')->nullable();
            $table->foreign('verify_by')->references('id')->on('users.users');

            $table->dateTime('approve_dt')->nullable();
            $table->unsignedBigInteger('approve_by')->nullable();
            $table->foreign('approve_by')->references('id')->on('users.users');

            $table->string('accessories_detail', 210)->nullable();

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
        Schema::dropIfExists('assessment.assessment_form_check_lvl1');
    }
}
