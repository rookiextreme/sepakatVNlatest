<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefOwnerType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_owner_type', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->nullable();
            $table->string('desc_bm',50)->nullable();
            $table->string('desc_en',50)->nullable();
            $table->tinyinteger('status')->default(1);
            $table->string('display_for')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');
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
        Schema::dropIfExists('ref_owner_type');
    }
}
