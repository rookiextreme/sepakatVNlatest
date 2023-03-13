<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskflowSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taskflow_sub', function (Blueprint $table) {
            $table->id();
            $table->String('code',10);
            $table->String('name_bm',100)->nullable();
            $table->String('name_en',100)->nullable();

            $table->String('desc_bm',100)->nullable();
            $table->String('desc_en',100)->nullable();

            $table->unsignedBigInteger('taskflow_id');
            $table->foreign('taskflow_id')->references('id')->on('taskflow');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users.users');
            $table->timestamps();

            $table->boolean('is_multi')->default(false)->comment('for multi access');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taskflow_sub');
    }
}
