<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaklumatPembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saman.maklumat_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maklumat_kenderaan_saman_id');
            $table->string('receipt_no')->nullable();
            $table->decimal('total_payment')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable();
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
        Schema::dropIfExists('maklumat_pembayarans');
    }
}
