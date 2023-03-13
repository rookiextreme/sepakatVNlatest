<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumentSamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saman.dokumen_saman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maklumat_kenderaan_saman_id');
            $table->string('name_dokumen');
            $table->string('path_dokumen');

            $table->foreign('maklumat_kenderaan_saman_id')->references('id')->on('saman.maklumat_kenderaan_saman');
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
        Schema::dropIfExists('dokument_samen');
    }
}
