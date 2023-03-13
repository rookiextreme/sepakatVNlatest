<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrantDetailStatement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.warrant_detail_statement', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('wd_id')->nullable();
            $table->foreign('wd_id')->references('id')->on('maintenance.warrant_detail');

            $table->double('expense')->nullable();
            $table->double('advance')->nullable();
            $table->string('note')->nullable();

            $table->date('expense_dt')->nullable();
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
        Schema::dropIfExists('maintenance.warrant_detail_statement');
    }
}
