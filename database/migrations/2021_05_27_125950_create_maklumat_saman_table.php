<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaklumatSamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saman.maklumat_saman', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('maklumat_kenderaan_saman_id');
            $table->foreign('maklumat_kenderaan_saman_id')->references('id')->on('saman.maklumat_kenderaan_saman');

            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('locations.negeris');

            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('locations.daerahs');

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('locations.cawangans');

            $table->unsignedBigInteger('summon_type_id')->nullable();
            $table->foreign('summon_type_id')->references('id')->on('ref_summon_type');

            $table->unsignedBigInteger('summon_agency_id')->nullable();
            $table->foreign('summon_agency_id')->references('id')->on('ref_summon_agency');

            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('users.users');

            $table->string('summon_notice_no')->nullable();
            $table->date('notice_date')->nullable();
            $table->date('receive_notice_date')->nullable();
            $table->date('mistake_date')->nullable();
            $table->time('mistake_time')->nullable();
            $table->string('mistake_location')->nullable();
            $table->double('total_compound')->nullable();
            $table->string('compound_reason')->nullable();

            $table->boolean('change_summon_owner')->default(false);
            $table->string('change_summon_owner_note')->nullable();
            $table->string('owner_name')->nullable();

            $table->string('pic_name1')->nullable();
            $table->string('pic_name2')->nullable();
            $table->string('pic_email1')->nullable();
            $table->string('pic_email2')->nullable();

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
        Schema::dropIfExists('maklumat_samen');
    }
}
