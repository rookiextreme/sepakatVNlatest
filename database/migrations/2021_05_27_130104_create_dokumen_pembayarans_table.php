<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenPembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saman.dokumen_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maklumat_pembayaran_id');
            $table->string('name_dokumen');
            $table->string('path_dokumen');
            $table->foreign('maklumat_pembayaran_id')->references('id')->on('saman.maklumat_pembayarans');
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
        Schema::dropIfExists('dokumen_pembayarans');
    }
}
