<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentSafety extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('assessment.assessment_safety', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number');
            $table->string('applicant_name');
            $table->string('phone_no');
            $table->string('ic_no')->nullable();
            $table->string('email');
            $table->string('address');
            $table->string('postcode');

            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('ref_state');

            $table->string('department_name');
            $table->string('hod_title');
            $table->string('no_ptj')->nullable();

            $table->timestamp('appointment_dt1')->nullable();
            $table->timestamp('appointment_dt2')->nullable();
            $table->timestamp('appointment_dt3')->nullable();
            $table->timestamp('appointment_dt')->nullable()->comment('This is last appoointment Data once selected by approval/verifier');
            $table->boolean('is_other_app_dt')->default(false);

            $table->integer('ttl_draf')->default(0);
            $table->integer('ttl_appointment')->default(0);
            $table->integer('ttl_assess')->default(0);
            $table->integer('ttl_evaluate')->default(0);
            $table->integer('ttl_approve')->default(0);
            $table->integer('ttl_complete')->default(0);
            $table->integer('ttl_vehicle')->default(0);

            $table->unsignedBigInteger('agency_id')->nullable();
            $table->foreign('agency_id')->references('id')->on('ref_agency');

            $table->unsignedBigInteger('workshop_id')->nullable();
            $table->foreign('workshop_id')->references('id')->on('ref_workshop');

            $table->unsignedBigInteger('app_status_id')->nullable();
            $table->foreign('app_status_id')->references('id')->on('assessment.assessment_application_status');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

            $table->boolean('is_migrate')->default(false);

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
        Schema::dropIfExists('assessment.assessment_safety');
    }
}
