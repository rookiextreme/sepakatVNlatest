<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_role', function (Blueprint $table) {
            $table->id();
            $table->string('code',10);
            $table->string('desc_bm',100);
            $table->string('desc_en',100)->nullable();
            $table->string('task_desc_bm');
            $table->string('task_desc_en')->nullable();
            $table->boolean('can_delete')->default(false);
            $table->unsignedBigInteger('ref_role_access_id')->nullable();
            $table->foreign('ref_role_access_id')->references('id')->on('ref_role_access');

            $table->unsignedBigInteger('workshop_id')->nullable();
            $table->foreign('workshop_id')->references('id')->on('ref_workshop');

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
        Schema::dropIfExists('ref_role');
    }
}
