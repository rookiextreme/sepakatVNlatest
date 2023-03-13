<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceChecklistLvl2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.maintenance_checklist_lvl2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maintenance_type_id')->nullable();
            $table->foreign('maintenance_type_id')->references('id')->on('maintenance.type');

            $table->unsignedBigInteger('checklistlvl2_id')->nullable();
            $table->foreign('checklistlvl2_id')->references('id')->on('ref_component_checklist_lvl2');

            $table->unsignedBigInteger('maintenancechecklist_lvl1_id')->nullable();
            $table->foreign('maintenancechecklist_lvl1_id')->references('id')->on('maintenance.maintenance_checklist_lvl1');

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
