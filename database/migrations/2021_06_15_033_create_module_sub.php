<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_sub', function (Blueprint $table) {
            $table->id();
            $table->String('code',10);
            $table->String('name_bm',50)->nullable();
            $table->String('name_en',50)->nullable();

            $table->String('desc_bm',50)->nullable();
            $table->String('desc_en',50)->nullable();

            $table->integer('level')->nullable();

            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')->references('id')->on('module');

            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('module_sub');
    }
}
