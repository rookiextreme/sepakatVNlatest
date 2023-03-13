<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFleetProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleet.fleet_project', function (Blueprint $table) {
            $table->id();
            $table->string('project_name',400)->nullable();
            $table->string('contract_no')->nullable();
            $table->string('hopt')->nullable();
            $table->string('contractor_name')->nullable();
            $table->string('ministry')->nullable();
            $table->date('project_start_dt')->nullable();
            $table->date('project_end_dt')->nullable();
            $table->date('project_cpc_dt')->nullable();
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
        Schema::dropIfExists('fleet.fleet_project');
    }
}
