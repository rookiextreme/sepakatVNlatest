<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.monitoring_info', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id')->references('id')->on('maintenance.job_vehicle_examination_form');

            $table->unsignedBigInteger('jve_form_repair_id')->nullable();
            $table->foreign('jve_form_repair_id')->references('id')->on('maintenance.job_vehicle_examination_form_repair');

            $table->unsignedBigInteger('ref_info_id')->nullable();
            $table->foreign('ref_info_id')->references('id')->on('maintenance.ref_monitoring_info');
            $table->date('monitoring_dt')->nullable();
            $table->string('note')->nullable();

            $table->string('doc_type')->nullable();
            $table->string('doc_format')->nullable();
            $table->string('doc_path')->nullable();
            $table->string('doc_name')->nullable();
            $table->string('doc_path_thumbnail')->nullable();

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
        Schema::dropIfExists('maintenance.monitoring_info');
    }
}
