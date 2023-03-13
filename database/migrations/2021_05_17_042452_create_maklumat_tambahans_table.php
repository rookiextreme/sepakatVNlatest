<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaklumatTambahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kenderaans.maklumat_tambahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftaran_id');
            $table->string('no_id_pemunya')->nullable();
            $table->string('no_jkr')->nullable();
            $table->string('no_loji')->nullable();
            $table->date('tarikh_cukai_jalan')->nullable();
            $table->double('harga_perolehan')->nullable();
            $table->date('tarikh_pembelian_kenderaan')->nullable();
            $table->string('no_lo')->nullable();
            $table->date('tarikh_pemeriksaan_fizikal')->nullable();
            $table->date('tarikh_pemeriksaan_keselamatan')->nullable();
            $table->date('tarikh_kemaskini')->nullable();
            $table->date('acqDt')->nullable()->comment('acquisition');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

            $table->foreign('pendaftaran_id')->references('id')->on('kenderaans.pendaftarans');
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
        Schema::dropIfExists('kenderaans.maklumat_tambahans');
    }
}
