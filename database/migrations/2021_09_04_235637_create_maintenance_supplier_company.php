<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceSupplierCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.supplier_company', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('form_id')->nullable();
            $table->unsignedBigInteger('jve_form_repair_id')->nullable();
            // $table->foreign('form_id')->references('id')->on('maintenance.job_vehicle_examination_form');

            $table->string('company_name')->nullable();

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
        Schema::dropIfExists('maintenance.supplier_company');
    }
}
