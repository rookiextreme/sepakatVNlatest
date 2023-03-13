<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaklumatKenderaanSamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saman.maklumat_kenderaan_saman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftaran_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('status_saman_id');
            $table->string('emel_ketua_jabatan')->nullable();
            $table->string('alamat_pejabat_pemilik')->nullable();

            $table->unsignedBigInteger('summon_notice_doc_id')->nullable();
            $table->foreign('summon_notice_doc_id')->references('id')->on('saman.summon_document');

            // $table->foreign('pendaftaran_id')->references('id')->on('kenderaans.pendaftarans');
            $table->foreign('user_id')->references('id')->on('users.users');
            $table->foreign('status_saman_id')->references('id')->on('saman.status_saman');

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
        Schema::dropIfExists('saman.maklumat_kenderaan_saman');
    }
}
