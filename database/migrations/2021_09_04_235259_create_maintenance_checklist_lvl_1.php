<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceChecklistLvl1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.maintenance_checklist_lvl1', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maintenance_type_id')->nullable();
            $table->foreign('maintenance_type_id')->references('id')->on('maintenance.type');

            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('maintenance.job_vehicle');

            $table->unsignedBigInteger('checklistlvl1_id')->nullable();
            $table->foreign('checklistlvl1_id')->references('id')->on('ref_component_checklist_lvl1');

            $table->boolean('is_pass')->default(false);

            $table->string('note')->nullable();

            $table->unsignedBigInteger('noted_by')->nullable();
            $table->foreign('noted_by')->references('id')->on('users.users');

            $table->boolean('is_repair')->nullable();
            $table->boolean('is_replacement')->nullable();
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
        Schema::dropIfExists('maintenance.maintenance_checklist_lvl1');
    }
}
