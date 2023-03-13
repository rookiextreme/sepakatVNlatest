<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement', function (Blueprint $table) {
            $table->id();
            $table->string('title_bm')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title')->nullable();
            $table->string('desc_bm_1')->nullable();
            $table->string('desc_bm_2')->nullable();
            $table->string('desc_en_1')->nullable();
            $table->string('desc_en_2')->nullable();
            $table->date('start_dt')->nullable();
            $table->date('end_dt')->nullable();
            $table->unsignedBigInteger('type_announce_id');
            $table->foreign('type_announce_id')->references('id')->on('ref_type_announcement');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->integer('status')->default(0);
            $table->integer('sorting')->default(0);

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
        Schema::dropIfExists('announcement');
    }
}
