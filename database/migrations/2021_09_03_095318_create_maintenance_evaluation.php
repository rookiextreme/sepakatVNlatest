<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceEvaluation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.evaluation', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number',50);
            $table->string('applicant_name',100);
            $table->string('phone_no',50);

            $table->string('email',50);
            $table->string('address');
            $table->string('postcode',20);
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('ref_state');

            $table->string('department_name',100);
            $table->string('hod_name',100);
            $table->timestamp('appointment_dt1')->nullable();
            $table->timestamp('appointment_dt2')->nullable();
            $table->timestamp('appointment_dt3')->nullable();
            $table->timestamp('appointment_dt')->nullable()->comment('This is last appoointment Data once selected by approval/verifier');
            $table->boolean('is_other_app_dt')->default(false);

            $table->unsignedBigInteger('assign_engineer_by')->nullable();
            $table->foreign('assign_engineer_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('assistant_engineer_by')->nullable();
            $table->foreign('assistant_engineer_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('agency_id')->nullable();
            $table->foreign('agency_id')->references('id')->on('ref_agency');
            $table->unsignedBigInteger('workshop_id')->nullable();
            $table->foreign('workshop_id')->references('id')->on('ref_workshop');
            $table->unsignedBigInteger('applicant_workshop_id')->nullable();
            $table->foreign('applicant_workshop_id')->references('id')->on('ref_workshop');
            $table->unsignedBigInteger('engineer_workshop_id')->nullable();
            $table->foreign('engineer_workshop_id')->references('id')->on('ref_workshop');
            $table->unsignedBigInteger('app_status_id')->nullable();
            $table->foreign('app_status_id')->references('id')->on('maintenance.application_status');

            //assessed
            $table->date('assessed_dt')->nullable();
            $table->unsignedBigInteger('assessed_by')->nullable();
            $table->foreign('assessed_by')->references('id')->on('users.users');

            //evaluated
            $table->date('evaluated_dt')->nullable();
            $table->unsignedBigInteger('evaluated_by')->nullable();
            $table->foreign('evaluated_by')->references('id')->on('users.users');

            //approved
            $table->date('approved_dt')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('maintenance.evaluation');
    }
}
