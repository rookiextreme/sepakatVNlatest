<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticBookingVehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic.logistic_booking_vehicle', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('logistic.logistic_booking');

            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')->references('id')->on('ref_sub_category');
            
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->foreign('vehicle_type_id')->references('id')->on('ref_sub_category_type');

            $table->unsignedBigInteger('placement_id')->nullable();
            $table->foreign('placement_id')->references('id')->on('fleet.fleet_placement');

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('ref_owner');

            $table->unsignedBigInteger('total_passenger')->nullable();
            $table->unsignedBigInteger('total_unit_need')->nullable();

            $table->boolean('is_need_driver')->default(false);
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('users.users');

            $table->string('driver_phone_no',20)->nullable();

            $table->string('note')->nullable();

            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('assign_vehicle_by')->nullable();
            $table->foreign('assign_vehicle_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('logistic.vehicle_status');

            $table->string('spare_driver_name',50)->nullable();
            $table->string('next_odometer',50)->nullable();
            $table->string('before_odometer',50)->nullable();
            $table->timestamp('task_datetime')->nullable();
            $table->timestamp('task_end_datetime')->nullable();
            $table->string('total_price_tng_used')->nullable();
            $table->string('oil_used')->nullable();
            $table->unsignedBigInteger('fuel_receipt_id')->nullable();
            $table->foreign('fuel_receipt_id')->references('id')->on('logistic.logistic_document');

            $table->unsignedBigInteger('vehicle_passenger_doc_id')->nullable();
            $table->foreign('vehicle_passenger_doc_id')->references('id')->on('logistic.logistic_document');

            $table->string('fleet_table',50)->default('department');

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
        Schema::dropIfExists('logistic.logistic_booking_vehicle');
    }
}
