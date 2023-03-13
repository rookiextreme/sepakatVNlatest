<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticPassenger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic.passenger', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('phone_no')->nullable();

            $table->unsignedBigInteger('logistic_booking_vehicle_id')->nullable();
            $table->foreign('logistic_booking_vehicle_id')->references('id')->on('logistic.logistic_booking_vehicle');

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
        Schema::dropIfExists('logistic.passenger');
    }
}
