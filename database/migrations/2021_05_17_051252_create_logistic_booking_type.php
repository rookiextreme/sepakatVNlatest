<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticBookingType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic.logistic_booking_type', function (Blueprint $table) {
            $table->id();

            $table->string('desc_bm',50)->nullable();
            $table->string('desc_en',50)->nullable();

            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('logistic.logistic_booking_type');
    }
}
