<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentAccidentVehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('assessment.assessment_accident_vehicle', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('assessment_accident_id')->nullable();
            $table->foreign('assessment_accident_id')->references('id')->on('assessment.assessment_accident');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('ref_category');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')->references('id')->on('ref_sub_category');
            $table->unsignedBigInteger('sub_category_type_id')->nullable();
            $table->foreign('sub_category_type_id')->references('id')->on('ref_sub_category_type');

            $table->date('purchase_dt')->nullable();
            $table->string('company_name')->nullable();
            $table->string('lo_no')->nullable();

            $table->boolean('is_gover')->default(false);

            $table->string('evaluation_type')->nullable();
            $table->unsignedBigInteger('vehicle_image')->nullable();
            $table->foreign('vehicle_image')->references('id')->on('assessment.assessment_formcheck_doc');

            $table->string('plate_no')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('chasis_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('phone_no')->nullable();
            $table->dateTime('report_dt')->nullable();
            $table->string('driver_mykad')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('general_note')->nullable();
            $table->float('odometer')->nullable();
            $table->float('pay_rates')->nullable();
            $table->float('additional_fee')->nullable();
            $table->float('total')->nullable();
            $table->float('estimate_price')->nullable();
            $table->float('total_cost_rate')->nullable();
            $table->boolean('given_value')->default(false);

            $table->boolean('in_assessment')->default(false);
            $table->boolean('approval')->nullable();

            $table->unsignedBigInteger('vehicle_brand_id')->nullable();
            $table->foreign('vehicle_brand_id')->references('id')->on('vehicles.brands');

            $table->string('model_name')->nullable();
            $table->integer('manufacture_year')->nullable();
            $table->date('registration_vehicle_dt')->nullable();

            $table->dateTime('app_datetime')->nullable()->nullable();

            $table->string('cert_hash_key')->nullable()->nullable();

            $table->unsignedBigInteger('assessment_vehicle_status_id')->nullable();
            $table->foreign('assessment_vehicle_status_id')->references('id')->on('assessment.assessment_vehicle_status');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

            $table->dateTime('foremen_dt')->nullable();
            $table->unsignedBigInteger('foremen_by')->nullable();
            $table->foreign('foremen_by')->references('id')->on('users.users');

            $table->dateTime('assessment_dt')->nullable();
            $table->unsignedBigInteger('assessment_by')->nullable();
            $table->foreign('assessment_by')->references('id')->on('users.users');

            $table->dateTime('verify_dt')->nullable();
            $table->unsignedBigInteger('verify_by')->nullable();
            $table->foreign('verify_by')->references('id')->on('users.users');

            $table->dateTime('approve_dt')->nullable();
            $table->unsignedBigInteger('approve_by')->nullable();
            $table->foreign('approve_by')->references('id')->on('users.users');

            $table->dateTime('evaluate_dt')->nullable();
            $table->unsignedBigInteger('evaluate_by')->nullable();
            $table->foreign('evaluate_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('assessment.assessment_accident_vehicle');
    }
}
