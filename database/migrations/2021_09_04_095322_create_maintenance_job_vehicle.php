<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceJobVehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.job_vehicle', function (Blueprint $table) {
            $table->id();

            $table->string('maintenance_job_purpose_type')->nullable();
            $table->string('complaint_damage')->nullable();
            $table->date('last_service_dt')->nullable();

            $table->unsignedBigInteger('maintenance_job_id')->nullable();
            $table->foreign('maintenance_job_id')->references('id')->on('maintenance.job');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('ref_category');

            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')->references('id')->on('ref_sub_category');

            $table->unsignedBigInteger('sub_category_type_id')->nullable();
            $table->foreign('sub_category_type_id')->references('id')->on('ref_sub_category_type');

            $table->date('purchase_dt')->nullable();
            $table->string('company_name')->nullable();
            $table->string('lo_no')->nullable();
            $table->string('current_loc');

            $table->boolean('is_gover')->default(false);

            $table->string('plate_no',20);
            $table->string('engine_no',20);
            $table->string('chasis_no',20);

            $table->unsignedBigInteger('vehicle_brand_id');
            $table->foreign('vehicle_brand_id')->references('id')->on('vehicles.brands');

            $table->unsignedBigInteger('fuel_type_id');
            $table->foreign('fuel_type_id')->references('id')->on('ref_engine_fuel_type');

            $table->string('model_name',100);
            $table->integer('manufacture_year')->nullable();
            $table->date('registration_vehicle_dt')->nullable();

            $table->dateTime('app_datetime')->nullable();

            $table->string('cert_hash_key')->nullable();

            $table->boolean('is_maintained')->default(false);

            $table->string('tested_detail')->nullable();
            $table->date('next_service_dt')->nullable();
            $table->integer('next_service_odometer')->nullable();

            $table->unsignedBigInteger('maintenance_vehicle_status_id')->nullable();
            $table->foreign('maintenance_vehicle_status_id')->references('id')->on('maintenance.vehicle_status');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('foremen_by')->nullable();
            $table->foreign('foremen_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('assessment_by')->nullable();
            $table->foreign('assessment_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('verify_by')->nullable();
            $table->foreign('verify_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('maintenance.job_vehicle');
    }
}
