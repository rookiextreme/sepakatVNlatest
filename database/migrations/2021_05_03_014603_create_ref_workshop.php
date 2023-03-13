<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefWorkshop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_workshop', function (Blueprint $table) {
            $table->id();
            $table->string('code',10);
            $table->string('desc',100);
            $table->string('code_warrant_ofs',20);
            $table->tinyinteger('status')->default(1);
            $table->string('ref_code',10)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');
            $table->foreign('state_id')->references('id')->on('ref_state');
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
        Schema::dropIfExists('ref_workshop');
    }
}
