<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGovAgencyStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users.gov_agency_staff', function (Blueprint $table) {
            $table->id();

            $table->string('designation')->nullable();
            $table->string('division_desc')->nullable();

            $table->unsignedBigInteger('detail_id');
            $table->foreign('detail_id')->references('id')->on('users.details');

            $table->unsignedBigInteger('agency_id')->nullable();
            $table->foreign('agency_id')->references('id')->on('ref_agency');
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
        Schema::dropIfExists('users.gov_agency_staff');
    }
}
