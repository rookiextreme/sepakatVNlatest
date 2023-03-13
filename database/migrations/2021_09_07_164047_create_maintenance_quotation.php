<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceQuotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.quotation', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('job_v_exam_id')->nullable();
//            $table->foreign('job_v_exam_id')->references('id')->on('maintenance.job_vehicle_examination_form');

            $table->unsignedBigInteger('repair_method_id')->nullable();
            $table->foreign('repair_method_id')->references('id')->on('maintenance.repair_method');

            $table->string('quotation_no',50);
            $table->string('company_name',100);
            $table->date('quotation_dt');
            $table->date('sst_dt')->nullable();
            $table->double('total_price');
            $table->date('end_dt')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('waran_type_id')->nullable();
            $table->foreign('waran_type_id')->references('id')->on('maintenance.waran_type');

            $table->unsignedBigInteger('osol_type_id')->nullable();
            $table->foreign('osol_type_id')->references('id')->on('maintenance.osol_type');

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
        Schema::dropIfExists('maintenance.quotation');
    }
}
