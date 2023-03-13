<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefSettingSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_setting_sub', function (Blueprint $table) {
            $table->id();
            $table->string('code',10);
            $table->string('name',50)->nullable();
            $table->string('desc',50)->nullable(); //day week month
            $table->tinyinteger('status')->default(0);
            $table->string('type')->default('radio')->comment('example radio/input/select');
            $table->string('function_for',50)->default('scheduler');
            $table->tinyInteger('value')->default(0);

            $table->unsignedBigInteger('setting_id')->nullable();
            $table->foreign('setting_id')->references('id')->on('ref_setting');

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
        Schema::dropIfExists('ref_setting_sub');
    }
}
