<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentDisposalVehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment.assessment_disposal_vehicle', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('assessment_disposal_id')->nullable();
            $table->foreign('assessment_disposal_id')->references('id')->on('assessment.assessment_disposal');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('ref_category');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')->references('id')->on('ref_sub_category');
            $table->unsignedBigInteger('sub_category_type_id')->nullable();
            $table->foreign('sub_category_type_id')->references('id')->on('ref_sub_category_type');

            $table->date('purchase_dt');
            $table->string('company_name')->nullable();
            $table->string('lo_no')->nullable();
            $table->string('location')->nullable();
            $table->float('original_price');
            $table->string('aset_regno');
            $table->string('nc_no');

            $table->boolean('is_gover')->default(false);
            $table->boolean('is_move')->default(false);

            $table->string('plate_no');
            $table->string('engine_no');
            $table->string('chasis_no');
            $table->integer('odometer')->nullable();
            $table->unsignedBigInteger('veh_img_doc')->nullable();

            $table->string('evaluation_type')->nullable();
            $table->unsignedBigInteger('vtl_doc')->nullable();
            $table->foreign('vtl_doc')->references('id')->on('assessment.assessment_formcheck_doc');

            $table->unsignedBigInteger('vehicle_brand_id')->nullable();
            $table->foreign('vehicle_brand_id')->references('id')->on('vehicles.brands');

            $table->string('model_name');
            $table->integer('manufacture_year');
            $table->date('registration_vehicle_dt');

            $table->integer('mileage_distance')->default(0);
            $table->integer('hours_used')->default(0);
            $table->integer('delivery_service')->default(0);
            $table->float('earlier_maintenance_cost')->default(0);
            $table->float('current_maintenance_cost')->default(0);
            $table->float('current_value')->default(0);
            $table->float('post_current_value')->default(0);
            $table->integer('post_durability')->default(0);
            $table->float('estimate_value_after')->default(0);
            $table->integer('manual_depreciation')->default(0);

            $table->dateTime('app_datetime')->nullable();

            $table->string('cert_hash_key')->nullable();
            $table->string('cert_ref_number')->nullable();
            $table->boolean('in_assessment')->default(false);
            $table->integer('approval')->default(0);

            $table->longText('kewpa_remarks')->nullable();
            $table->longText('kewpa_remarks2')->nullable();

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
            $table->string('other_sub_category_type')->nullable();
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
        Schema::dropIfExists('assessment.assessment_disposal_vehicle');
    }
}
