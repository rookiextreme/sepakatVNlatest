<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaklumatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kenderaans.maklumats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftaran_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('sub_category_type_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('no_chasis',50)->nullable();
            $table->string('no_engine',50)->nullable();
            $table->string('status')->nullable();
            $table->date('tarikh_belian')->nullable();
            $table->string('no_resit')->nullable();
            $table->string('pembeli')->nullable();

            $table->foreign('pendaftaran_id')->references('id')->on('kenderaans.pendaftarans');
            $table->foreign('category_id')->references('id')->on('ref_category');
            $table->foreign('sub_category_id')->references('id')->on('ref_sub_category');
            $table->foreign('sub_category_type_id')->references('id')->on('ref_sub_category_type');
            $table->foreign('brand_id')->references('id')->on('vehicles.brands');
            $table->foreign('model_id')->references('id')->on('vehicles.vehicle_models');

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
        Schema::dropIfExists('kenderaans.maklumats');
    }
}
