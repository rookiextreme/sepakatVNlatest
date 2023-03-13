<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceJobVeFormChecklist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.job_ve_form_checklist', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id')->references('id')->on('maintenance.job_vehicle_examination_form');

            $table->unsignedBigInteger('jve_form_repair_id')->nullable();
            $table->foreign('jve_form_repair_id')->references('id')->on('maintenance.job_vehicle_examination_form_repair');

            $table->unsignedBigInteger('component_lvl1_id')->nullable();
            $table->foreign('component_lvl1_id')->references('id')->on('ref_component_lvl1');

            $table->unsignedBigInteger('component_lvl2_id')->nullable();
            $table->foreign('component_lvl2_id')->references('id')->on('ref_component_lvl2');

            $table->unsignedBigInteger('component_lvl3_id')->nullable();
            $table->foreign('component_lvl3_id')->references('id')->on('ref_component_lvl3');

            $table->tinyinteger('lvl')->nullable();

            $table->boolean('is_pass')->nullable();

            $table->string('noted')->nullable();

            $table->unsignedBigInteger('noted_by')->nullable();
            $table->foreign('noted_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->date('prepared_dt')->nullable();
            $table->unsignedBigInteger('prepared_by')->nullable();
            $table->foreign('prepared_by')->references('id')->on('users.users');

            $table->date('verified_dt')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->foreign('verified_by')->references('id')->on('users.users');

            $table->date('completed_dt')->nullable();
            $table->unsignedBigInteger('completed_by')->nullable();
            $table->foreign('completed_by')->references('id')->on('users.users');
            
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
        Schema::dropIfExists('maintenance.job_ve_form_checklist');
    }
}
