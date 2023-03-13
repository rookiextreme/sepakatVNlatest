<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceEvaluationVehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.evaluation_vehicle', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('maintenance_evaluation_id')->nullable();
            $table->foreign('maintenance_evaluation_id')->references('id')->on('maintenance.evaluation');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('ref_category');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')->references('id')->on('ref_sub_category');
            $table->unsignedBigInteger('sub_category_type_id')->nullable();
            $table->foreign('sub_category_type_id')->references('id')->on('ref_sub_category_type');

            $table->date('purchase_dt')->nullable();
            $table->string('company_name')->nullable();
            $table->string('lo_no',50)->nullable();
            $table->string('current_loc');
            //$table->timestamp('date_entry')->nullable();
            $table->string('date_entry')->nullable();

            $table->boolean('is_gover')->default(false);

            $table->string('plate_no');
            $table->string('engine_no');
            $table->string('chasis_no');
            $table->integer('odometer')->nullable();
            $table->unsignedBigInteger('vehicle_brand_id');
            $table->foreign('vehicle_brand_id')->references('id')->on('vehicles.brands');

            $table->unsignedBigInteger('fuel_type_id');
            $table->foreign('fuel_type_id')->references('id')->on('ref_engine_fuel_type');

            $table->string('model_name',100);
            $table->integer('manufacture_year')->nullable();
            $table->date('registration_vehicle_dt')->nullable();

            $table->dateTime('app_datetime')->nullable();

            $table->string('cert_hash_key')->nullable();

            $table->boolean('is_carry_over_maintenance')->default(false);
            $table->unsignedBigInteger('evaluation_letter_id')->nullable();
            // $table->foreign('evaluation_letter_id')->references('id')->on('maintenance.evaluation_template_letter');

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
            $table->date('assessment_dt')->nullable();

            $table->unsignedBigInteger('verify_by')->nullable();
            $table->foreign('verify_by')->references('id')->on('users.users');
            $table->date('verify_dt')->nullable();

            // $table->unsignedBigInteger('approve_by')->nullable();
            // $table->foreign('approve_by')->references('id')->on('users.users');

            // $table->unsignedBigInteger('evaluate_by')->nullable();
            // $table->foreign('evaluate_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('maintenance.evaluation_vehicle');
    }
}
