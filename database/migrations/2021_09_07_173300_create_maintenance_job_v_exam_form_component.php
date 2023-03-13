<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceJobVExamFormComponent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.mjob_exam_form_component', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id')->references('id')->on('maintenance.job_vehicle_examination_form');

            $table->unsignedBigInteger('jve_form_repair_id')->nullable();
            $table->foreign('jve_form_repair_id')->references('id')->on('maintenance.job_vehicle_examination_form_repair');

            $table->unsignedBigInteger('maintenance_job_purpose_type_id')->nullable();
            $table->foreign('maintenance_job_purpose_type_id')->references('id')->on('maintenance.job_purpose_type');

            $table->unsignedBigInteger('ref_component_lvl1_id')->nullable();
            $table->foreign('ref_component_lvl1_id')->references('id')->on('ref_component_lvl1');

            $table->unsignedBigInteger('ref_component_lvl2_id')->nullable();
            $table->foreign('ref_component_lvl2_id')->references('id')->on('ref_component_lvl2');

            $table->string('note')->nullable();

            $table->integer('quantity')->nullable();
            $table->double('per_price')->nullable();
            $table->double('total_price')->nullable();
            $table->double('price_budget')->nullable();

            $table->double('testing_dt')->nullable();
            $table->string('tested_by')->nullable();
            $table->string('test_detail')->nullable();

            $table->unsignedBigInteger('noted_by')->nullable();
            $table->foreign('noted_by')->references('id')->on('users.users');
            $table->timestamps();

            $table->text('detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance.job_v_exam_form_component');
    }
}
