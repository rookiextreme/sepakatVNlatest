<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusSemakansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kenderaans.status_semakans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftaran_id');
            $table->unsignedBigInteger('vapp_status_id');
            $table->string('comment')->nullable();
            $table->foreign('pendaftaran_id')->references('id')->on('kenderaans.pendaftarans');
            $table->foreign('vapp_status_id')->references('id')->on('identifiers.vapp_status');
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
        Schema::dropIfExists('kenderaans.status_semakans');
    }
}
