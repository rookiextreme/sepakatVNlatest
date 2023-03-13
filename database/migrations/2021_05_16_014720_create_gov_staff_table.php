<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGovStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users.gov_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_id');
            $table->String('designation')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->String('unit')->nullable();
            $table->foreign('detail_id')->references('id')->on('users.details');
            $table->foreign('sector_id')->references('id')->on('ref_sector');
            $table->foreign('branch_id')->references('id')->on('ref_branch');
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
        Schema::dropIfExists('users.gov_staff');
    }
}
