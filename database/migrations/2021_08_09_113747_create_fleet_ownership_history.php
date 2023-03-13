<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFleetOwnershipHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleet.fleet_ownership_history', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vehicle_id');

            $table->unsignedBigInteger('owner_type_id')->nullable();
            $table->foreign('owner_type_id')->references('id')->on('ref_owner_type');

            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('fleet.fleet_ownership_history');
    }
}
