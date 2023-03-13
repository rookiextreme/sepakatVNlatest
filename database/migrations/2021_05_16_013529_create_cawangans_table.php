<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCawangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations.cawangans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('negeri_id')->nullable();
            $table->unsignedBigInteger('daerah_id')->nullable();
            $table->string('cawangan');
            $table->foreign('negeri_id')->references('id')->on('locations.negeris');
            $table->foreign('daerah_id')->references('id')->on('locations.daerahs');
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
        Schema::dropIfExists('locations.cawangans');
    }
}
