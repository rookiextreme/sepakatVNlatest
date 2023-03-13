<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceMjobExamProcurement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.mjob_exam_procurement', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('mjob_exam_form_component_id')->nullable();
            $table->foreign('mjob_exam_form_component_id')->references('id')->on('maintenance.mjob_exam_form_component');

            $table->unsignedBigInteger('supplier_company_id')->nullable();
            $table->foreign('supplier_company_id')->references('id')->on('maintenance.supplier_company');

            $table->double('price')->nullable();

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
        Schema::dropIfExists('maintenance.mjob_exam_procurement');
    }
}
