<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kenderaans.pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('negeri_id')->nullable();
            $table->unsignedBigInteger('cawangan_id')->nullable();
            $table->unsignedBigInteger('placement_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->string('no_pendaftaran')->nullable();
            $table->string('no_id_pemunya')->nullable();
            $table->string('hak_milik')->nullable();
            $table->string('no_jkr')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_email')->nullable();

            $table->foreign('user_id')->references('id')->on('users.users');
            $table->foreign('negeri_id')->references('id')->on('locations.negeris');
            $table->foreign('cawangan_id')->references('id')->on('locations.cawangans');
            $table->foreign('placement_id')->references('id')->on('locations.placement');

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
        Schema::dropIfExists('saman.dokumen_pembayarans');
        Schema::dropIfExists('saman.maklumat_pembayarans');
        Schema::dropIfExists('saman.dokumen_saman');
        Schema::dropIfExists('saman.maklumat_saman');
        Schema::dropIfExists('saman.maklumat_kenderaan_saman');
        Schema::dropIfExists('kenderaans.pendaftarans');
    }
}
