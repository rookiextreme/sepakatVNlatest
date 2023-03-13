<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic.logistic_booking', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('work_ins_letter_id')->nullable();
            $table->foreign('work_ins_letter_id')->references('id')->on('logistic.logistic_document');

            $table->string('spare_driver_name',50)->nullable();
            $table->string('tel_no',20)->nullable();
            $table->string('reason')->nullable();
            $table->string('destination')->nullable();
            $table->string('start_destination')->nullable();
            $table->string('end_destination')->nullable();
            $table->timestamp('start_datetime')->nullable();
            $table->timestamp('end_datetime')->nullable();

            // $table->string('odometer',50)->nullable();
            $table->timestamp('task_datetime')->nullable();
            $table->timestamp('task_end_datetime')->nullable();
            $table->string('total_price_tng_used')->nullable();
            $table->string('oil_used')->nullable();
            $table->string('note')->nullable();

            $table->string('next_odometer',50)->nullable();
            $table->string('before_odometer',50)->nullable();

            $table->unsignedBigInteger('booking_by');
            $table->foreign('booking_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('appl_id')->nullable();
            $table->foreign('appl_id')->references('id')->on('logistic.logistic_applicant');

            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('logistic.logistic_booking_status');

            $table->unsignedBigInteger('stay_id')->nullable();
            $table->foreign('stay_id')->references('id')->on('logistic.logistic_stay_status');

            $table->unsignedBigInteger('fuel_receipt_id')->nullable();
            $table->foreign('fuel_receipt_id')->references('id')->on('logistic.logistic_document');

            $table->date('submitted_dt')->nullable();
            $table->unsignedBigInteger('submitted_by')->nullable();
            $table->foreign('submitted_by')->references('id')->on('users.users');

            $table->date('approved_dt')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users.users');

            $table->string('booking_person_name')->nullable();
            $table->string('booking_person_email')->nullable();

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
        Schema::dropIfExists('logistic.logistic_booking');
    }
}
