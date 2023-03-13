<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentGovLoanVehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('assessment.assessment_gov_loan_vehicle', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('assessment_gov_loan_id')->nullable();
            $table->foreign('assessment_gov_loan_id')->references('id')->on('assessment.assessment_gov_loan');

            $table->string('applicant_name')->nullable();
            $table->string('applicant_ic_no')->nullable();
            $table->string('applicant_company')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('ref_category');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')->references('id')->on('ref_sub_category');
            $table->unsignedBigInteger('sub_category_type_id')->nullable();
            $table->foreign('sub_category_type_id')->references('id')->on('ref_sub_category_type');

            $table->date('purchase_dt')->nullable();
            $table->float('purchase_')->nullable();
            $table->string('company_name')->nullable();
            $table->string('lo_no')->nullable()->nullable();

            $table->boolean('is_gover')->default(false);
            $table->boolean('in_assessment')->default(false);
            $table->boolean('approval')->nullable();

            $table->string('evaluation_type')->nullable();
            $table->string('certificate_title')->nullable();
            $table->unsignedBigInteger('vtl_doc')->nullable();
            $table->foreign('vtl_doc')->references('id')->on('assessment.assessment_formcheck_doc');
            $table->unsignedBigInteger('veh_img_doc')->nullable();
            $table->foreign('veh_img_doc')->references('id')->on('assessment.assessment_formcheck_doc');
            $table->unsignedBigInteger('receipt_doc')->nullable();
            $table->foreign('receipt_doc')->references('id')->on('assessment.assessment_formcheck_doc');

            $table->string('plate_no');
            $table->string('engine_no');
            $table->string('chasis_no');
            $table->float('vehicle_price')->nullable();
            $table->integer('odometer')->nullable();

            $table->unsignedBigInteger('vehicle_brand_id')->nullable();
            $table->foreign('vehicle_brand_id')->references('id')->on('vehicles.brands');

            $table->string('model_name');
            $table->integer('manufacture_year');
            $table->date('registration_vehicle_dt');

            $table->float('original_price')->nullable();
            $table->float('current_price')->nullable();
            $table->float('market_price')->nullable();
            $table->float('estimate_repair')->nullable();
            $table->float('estimate_price')->nullable();
            $table->integer('durabilty')->nullable();

            $table->dateTime('app_datetime')->nullable();

            $table->string('cert_hash_key')->nullable();
            $table->string('cert_ref_number')->nullable();

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

            $table->longText('reason_changed')->nullable();

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
        Schema::dropIfExists('assessment.assessment_gov_loan_vehicle');
    }
}
