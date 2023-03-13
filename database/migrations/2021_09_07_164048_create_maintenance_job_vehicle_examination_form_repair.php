<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceJobVehicleExaminationFormRepair extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.job_vehicle_examination_form_repair', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('maintenance.job_vehicle');

            $table->unsignedBigInteger('jve_form_id')->nullable();
            $table->foreign('jve_form_id')->references('id')->on('maintenance.job_vehicle_examination_form');

            $table->unsignedBigInteger('repair_method_id')->nullable();
            $table->foreign('repair_method_id')->references('id')->on('maintenance.repair_method');

            $table->string('other_external_note')->nullable();
            $table->tinyInteger('is_research_market')->nullable();

            $table->double('price_budget')->nullable();
            $table->double('procurement_price')->nullable();

            $table->double('pro_budget_price')->nullable();
            $table->unsignedBigInteger('pro_budget_price_supl_id')->nullable();
            $table->foreign('pro_budget_price_supl_id')->references('id')->on('maintenance.supplier_company');
            $table->string('pro_budget_price_note', 100)->nullable();

            // $table->unsignedBigInteger('procure_supplier_id')->nullable();
            // $table->foreign('procure_supplier_id')->references('id')->on('maintenance.supplier_company');
            $table->date('rsm_prepared_dt')->nullable();
            $table->unsignedBigInteger('rsm_prepared_by')->nullable();
            $table->foreign('rsm_prepared_by')->references('id')->on('users.users');

            $table->date('rsm_verified_dt')->nullable();
            $table->unsignedBigInteger('rsm_verified_by')->nullable();
            $table->foreign('rsm_verified_by')->references('id')->on('users.users');

            $table->date('inspected_dt')->nullable();
            $table->unsignedBigInteger('inspected_by')->nullable();
            $table->foreign('inspected_by')->references('id')->on('users.users');

            $table->date('inspected_done_dt')->nullable();
            $table->unsignedBigInteger('inspected_done_by')->nullable();
            $table->foreign('inspected_done_by')->references('id')->on('users.users');

            $table->date('pro_prepared_dt')->nullable();
            $table->unsignedBigInteger('pro_prepared_by')->nullable();
            $table->foreign('pro_prepared_by')->references('id')->on('users.users');

            $table->date('pro_verified_dt')->nullable();
            $table->unsignedBigInteger('pro_verified_by')->nullable();
            $table->foreign('pro_verified_by')->references('id')->on('users.users');

            $table->date('pro_approved_dt')->nullable();
            $table->unsignedBigInteger('pro_approved_by')->nullable();
            $table->foreign('pro_approved_by')->references('id')->on('users.users');


            $table->unsignedBigInteger('external_repair_id')->nullable();
            $table->foreign('external_repair_id')->references('id')->on('maintenance.external_repair');

            $table->unsignedBigInteger('waran_type_id')->nullable();
            $table->foreign('waran_type_id')->references('id')->on('maintenance.waran_type');

            $table->unsignedBigInteger('osol_type_id')->nullable();
            $table->foreign('osol_type_id')->references('id')->on('maintenance.osol_type');

            $table->unsignedBigInteger('job_vehicle_status_id')->nullable();
            $table->foreign('job_vehicle_status_id')->references('id')->on('maintenance.job_vehicle_status');

            $table->date('tested_dt')->nullable();
            $table->unsignedBigInteger('tested_by')->nullable();
            $table->foreign('tested_by')->references('id')->on('users.users');

            $table->date('tested_done_dt')->nullable();
            $table->unsignedBigInteger('tested_done_by')->nullable();
            $table->foreign('tested_done_by')->references('id')->on('users.users');

            $table->string('tested_detail')->nullable();
            $table->string('tester_note', 100)->nullable();
            $table->date('next_service_dt')->nullable();
            $table->integer('next_service_odometer')->nullable();

            $table->unsignedBigInteger('internal_repair_status_id')->nullable();
            $table->foreign('internal_repair_status_id')->references('id')->on('maintenance.job_vehicle_maintenance_status');

            $table->unsignedBigInteger('ext_repair_status_id')->nullable();
            $table->foreign('ext_repair_status_id')->references('id')->on('maintenance.job_vehicle_maintenance_status');

            $table->string('inspect_type')->nullable();

            $table->double('advance')->nullable();
            $table->double('expense')->nullable();

            $table->string('lo_no',100)->nullable();
            $table->date('completed_dt')->nullable();
            $table->date('v_completed_dt')->nullable();

            $table->unsignedBigInteger('completed_by')->nullable();
            $table->foreign('completed_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('company_signature')->nullable();
            $table->foreign('company_signature')->references('id')->on('maintenance.job_doc');

            $table->unsignedBigInteger('warrant_detail_id')->nullable();
            // $table->foreign('warrant_detail_id')->references('id')->on('maintenance.warrant_detail');

            $table->boolean('is_start')->default(false);
            
            $table->text('other_damages')->nullable();
            $table->text('testing_info')->nullable();
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
        Schema::dropIfExists('maintenance.job_vehicle_examination_form_repair');
    }
}
