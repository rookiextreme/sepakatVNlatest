<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users.contractor_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_id');
            $table->string('company_name')->nullable();
            $table->string('ssm_no')->nullable();
            $table->string('latest_project_name')->nullable();
            $table->unsignedBigInteger('ministry_id')->nullable();
            $table->foreign('detail_id')->references('id')->on('users.details');
            $table->foreign('ministry_id')->references('id')->on('ref_sector');
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
        Schema::dropIfExists('users.contractor_staff');
    }
}
