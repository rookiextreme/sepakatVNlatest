<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisasterReadyBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic.disasterready_booking', function (Blueprint $table) {
            $table->id();

            $table->string('spare_driver_name',50)->nullable();
            $table->string('booking_person_name')->nullable();
            $table->string('booking_person_email',50)->nullable();
            $table->string('assembly_location')->nullable();
            $table->timestamp('assembly_datetime')->nullable();
            $table->string('trip_expense_type')->nullable();
            $table->string('tel_no',20)->nullable();
            $table->string('reason')->nullable();
            $table->string('destination')->nullable();
            // $table->string('start_destination')->nullable();
            // $table->string('end_destination')->nullable();
            $table->timestamp('start_datetime')->nullable();
            $table->timestamp('end_datetime')->nullable();
            $table->bigInteger('total_vehicle')->default(1);
            $table->bigInteger('total_passenger')->default();
            $table->string('disaster_center')->nullable();

            $table->string('odometer')->nullable();
            $table->unsignedBigInteger('before_odometer')->nullable();
            $table->unsignedBigInteger('after_odometer')->nullable();

            $table->timestamp('task_datetime')->nullable();
            $table->timestamp('task_end_datetime')->nullable();
            $table->string('total_price_tng_used')->nullable();
            $table->string('oil_used')->nullable();
            $table->string('note')->nullable();

            $table->unsignedBigInteger('vehicle_id')->nullable();

            $table->unsignedBigInteger('driver_id')->nullable();
            //TODO driver table
            //$table->foreign('driver_id')->references('id')->on('users.users');

            // $table->unsignedBigInteger('vehicle_type_id')->nullable();
            // $table->foreign('vehicle_type_id')->references('id')->on('ref_sub_category_type');

            $table->unsignedBigInteger('vehicle_type_id')->nullable();

            $table->unsignedBigInteger('booking_by');
            $table->foreign('booking_by')->references('id')->on('users.users');

            $table->date('submitted_dt')->nullable();
            $table->unsignedBigInteger('submitted_by')->nullable();
            $table->foreign('submitted_by')->references('id')->on('users.users');

            $table->date('approved_dt')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('logistic.disasterready_booking_status');

            $table->unsignedBigInteger('stay_id')->nullable();

            $table->unsignedBigInteger('agency_id')->nullable();
            $table->foreign('agency_id')->references('id')->on('ref_agency');

            $table->unsignedBigInteger('work_ins_letter_id')->nullable();
            $table->foreign('work_ins_letter_id')->references('id')->on('logistic.disasterready_document');

            $table->unsignedBigInteger('fuel_receipt_id')->nullable();
            $table->foreign('fuel_receipt_id')->references('id')->on('logistic.disasterready_document');

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
        Schema::dropIfExists('logistic.disasterready_booking');
    }
}
