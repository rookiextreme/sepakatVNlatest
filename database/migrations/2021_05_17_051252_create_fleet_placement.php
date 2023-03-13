<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFleetPlacement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleet.fleet_placement', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->nullable();
            $table->string('desc',100)->nullable();
            $table->tinyinteger('status')->default(1);
            $table->unsignedBigInteger('ref_state_id')->nullable();
            $table->foreign('ref_state_id')->references('id')->on('ref_state');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');
            $table->boolean('is_district_of_state')->default(false);
            $table->smallInteger('map_order')->nullable();
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
        Schema::dropIfExists('fleet.fleet_placement');
    }
}
