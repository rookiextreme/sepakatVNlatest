<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskflow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taskflow', function (Blueprint $table) {
            $table->id();
            $table->String('code',10);
            $table->String('name_bm',50)->nullable();
            $table->String('name_en',50)->nullable();

            $table->String('desc_bm',50)->nullable();
            $table->String('desc_en',50)->nullable();

            $table->boolean('is_verify')->default(false);
            $table->String('is_verify_bm')->nullable();
            $table->String('is_verify_en')->nullable();

            $table->boolean('is_appointment')->default(false);
            $table->String('is_appointment_bm')->nullable();
            $table->String('is_appointment_en')->nullable();

            $table->boolean('is_approval')->default(false);
            $table->String('is_approval_bm')->nullable();
            $table->String('is_approval_en')->nullable();

            $table->boolean('is_pass')->default(false);
            $table->String('is_pass_bm')->nullable();
            $table->String('is_pass_en')->nullable();

            $table->boolean('is_can_edit_after_approve')->default(false);
            $table->String('is_can_edit_after_approve_bm')->nullable();
            $table->String('is_can_edit_after_approve_en')->nullable();

            $table->boolean('is_can_dispose_federal')->default(false);
            $table->String('is_can_dispose_federal_bm')->nullable();
            $table->String('is_can_dispose_federal_en')->nullable();

            $table->boolean('is_can_dispose_state')->default(false);
            $table->String('is_can_dispose_state_bm')->nullable();
            $table->String('is_can_dispose_state_en')->nullable();

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('taskflow');
    }
}
