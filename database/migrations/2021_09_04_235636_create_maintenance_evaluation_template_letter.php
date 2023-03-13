<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceEvaluationTemplateLetter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('maintenance.evaluation_template_letter', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('maintenance.evaluation_vehicle');

            $table->unsignedBigInteger('evaluation_letter_type_id')->nullable();
            $table->foreign('evaluation_letter_type_id')->references('id')->on('maintenance.evaluation_letter_type');

            $table->string('ref_number')->nullable()->default('JKR.WSP.030-1/3 Jld . 34 (68)');
            $table->date('date', 50)->nullable();


            $table->string('placement_name')->nullable();
            $table->date('appointment_dt')->nullable();
            $table->string('officer_name')->nullable();
            $table->string('signature_quote')->nullable();
            $table->string('officer_designation',255)->nullable();

            // $table->string('postcode',10)->nullable();
            // $table->string('state_name',50)->nullable();
            // $table->string('postcode_and_state',100)->nullable();
            // $table->string('officer_address')->nullable();
            // $table->string('head_address')->nullable();
            // $table->string('telno',20)->nullable();
            // $table->string('faxno',20)->nullable();

            $table->double('total_budget')->nullable();

            $table->string('address_to')->nullable();
            $table->string('body_detail')->nullable();
            $table->string('officer_phone',20)->nullable();

            $table->string('vip_address')->nullable();

            $table->unsignedBigInteger('letter_status_id')->nullable();
            $table->foreign('letter_status_id')->references('id')->on('maintenance.evaluation_letter_status');

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
        Schema::dropIfExists('maintenance.evaluation_template_letter');
    }
}
